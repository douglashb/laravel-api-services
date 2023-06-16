<?php

namespace App\Http\Controllers\Remittance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Remittance\RemitAccountActivePutRequest;
use App\Http\Requests\Remittance\RemitChangePasswordPostRequest;
use App\Http\Resources\Remittance\PersonalInfoResource;
use App\Http\Resources\Remittance\RemitAutenticateSignupResource;
use App\Http\Resources\Remittance\RemitChangePasswordResource;
use App\Http\Resources\Remittance\RemitRequestPasswordResource;
use App\Http\Resources\Remittance\RemitResetPasswordResource;
use App\Http\Resources\Remittance\RemitSignupResource;
use App\Interfaces\Profile\UserRepository;
use App\Interfaces\Remittance\ProfileRemitRepository;
use App\Interfaces\Remittance\SessionRemitRepository;
use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use App\Libraries\UnitellerErrorCode;
use App\Libraries\UnitellerHandler;
use App\Services\Uniteller\Classes\BaseSession;
use App\Services\Uniteller\Classes\SetupPersonalInfo;
use App\Services\Uniteller\Classes\UserLogin;
use App\Services\Uniteller\Resources\UnitellerSessionResource;
use App\Services\Uniteller\UnitellerService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use JsonMapper;

class SecurityController extends Controller
{
    public function __construct(
        private ProfileRemitRepository $profileRepository,
        private SessionRemitRepository $remitSessionRepository,
        private UserRepository         $userRepository,
        private JsonMapper             $mapper
    )
    {
        $this->mapper = new JsonMapper();
        $this->mapper->bEnforceMapType = false;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function accountCreate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), $this->signupRules());

        if ($validator->fails()) {
            return ResponseHandler::badRequest(ApiErrorCode::REMIT_INVALID_DATA, $validator->errors()->first());
        }

        if (auth()->check()) {
            $userProfile = $request->user();
        } else {
            $userProfile = $this->userRepository->getByEmail($request->input('email'));
        }

        $remittanceProfile = $this->profileRepository->get($userProfile->id);

        if (! is_null($remittanceProfile)) {
            return ResponseHandler::badRequest(ApiErrorCode::REMIT_INVALID_DATA, __('user.user_remittance_exist'));
        }

        $result = app(UnitellerService::class)->security()->signup(
            new RemitSignupResource(
                $request->all() + $userProfile->toArray() + ['password' => $userProfile->auth]
            )
        );

        UnitellerErrorCode::setErrorCode($result['responseCode']);
        if (UnitellerErrorCode::isSuccess()) {
            Log::info('The remitance user: ' . $userProfile->id . ' registered in Uniteller with success.');

            $splitBirthDate = str_split($request->input('birth_date'), 2);
            $birthDate = $splitBirthDate[2] . $splitBirthDate[3] . '-' . $splitBirthDate[0] . '-' . $splitBirthDate[1];

            $this->userRepository->updateById(
                $userProfile->id,
                ['birth_date' => $birthDate] + $request->only(['address', 'zip_code', 'gender'])
            );

            $this->profileRepository->create([
                    'profile_user_id' => $userProfile->id,
                    'country' => 'USA',
                    'country_iso_code' => 'US',
                    'question_id' => config('internal.uniteller.question_id'),
                    'error_code' => $result['responseCode'],
                    'error_message' => $result['responseMessage'],
                    'answer' => $request->input('security_answer'),
                ] + $request->only(['destination_country_iso_code']));

        }

        Log::warning('The remittance user: ' . $userProfile->email . ' have issues. ErrorCode: ' . $result['responseCode'] . ' - ErrorMessage: ' . $result['responseMessage']);

        return UnitellerHandler::response($result);
    }

    /**
     * @param RemitAccountActivePutRequest $request
     * @return JsonResponse
     */
    public function accountActive(RemitAccountActivePutRequest $request): JsonResponse
    {
        $remittance_profile = $this->profileRepository->get($request->user()->id);

        if ($remittance_profile === null) {
            return ResponseHandler::badRequest(ApiErrorCode::REMIT_INVALID_DATA, __('remittance.user_not_registered'));
        }

        $result = app(UnitellerService::class)->security()->authenticateSignup(
            new RemitAutenticateSignupResource(
                $request->validated() + [
                    'password' => $request->user()->auth,
                    'email' => $request->user()->email
                ])
        );

        if ($result['responseCode'] === UnitellerErrorCode::PROVISIONAL_ACTIVE_USER_CODE) {
            $this->remitSessionRepository->setToken($request->user()->id, $result);
            $this->verifyProfileUser($request->user());
        }

        return UnitellerHandler::response($result);
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function userLogin(Request $request): JsonResponse
    {
        $remittanceProfile = $this->profileRepository->get($request->user()->id);
        if ($remittanceProfile === null) {
            return ResponseHandler::unauthorized(ApiErrorCode::REMIT_NEED_REGISTER, __('remittance.user_not_registered'));
        }

        $merchant = cache(session('merchant'));
        $unitellerService = $merchant['services']['uniteller'];
        $validator = Validator::make($request->only('uic'), [
            'uic' => 'string|digits:6',
        ]);

        if ($validator->fails()) {
            return ResponseHandler::unauthorized(ApiErrorCode::REMIT_INVALID_DATA, $validator->errors()->first());
        }

        $login = new UserLogin();
        $login->setPassword($request->user()->auth);
        $login->setUserId($request->user()->email);
        $login->setSaveUniqueDeviceId('Yes');
        $login->setUserIPAddress(session('user_remote_address'));
        $login->setUniqueDeviceId(session('user_device_id'));

        if ($request->has('uic')) {
            $login->setUic($request->input('uic'));
            $login->setUicReceptionMode($unitellerService['reception_mode']);
        }

        $result = app(UnitellerService::class)->security()->userLogin($login);
        UnitellerErrorCode::setErrorCode($result['responseCode']);

        if (UnitellerErrorCode::isNewDevice()) { // REGISTER NEW DEVICE ACCESS
            if (count($result['uicReceiptMode']) > 1) {
                $login->setUicReceptionMode($unitellerService['reception_mode']);
            } else {
                $login->setUicReceptionMode($result['uicReceiptMode'][0]['sourceMode']);
            }

            $result = app(UnitellerService::class)->security()->userLogin($login);
        }

        if (UnitellerErrorCode::isSuccess()) { // LOGIN SUCCESS
            session(['remit_user_token' => $result['token']]);
            $user = $request->user()->toArray() + ['id' => $request->user()->id];
            dispatch(function () use ($user, $result) {
                $this->remitSessionRepository->setToken($user['id'], $result);
                $this->verifyProfileUser($user); // FINISH REGISTRATION USER
            })->afterResponse();
            $remittanceProfile = $this->profileRepository->get($request->user()->id);

            if ($remittanceProfile->uic) {
                $this->profileRepository->setUicStatus($request->user()->id, false, '', '');
            }

            if ($remittanceProfile->locked) {
                $this->profileRepository->setLockedStatus($request->user()->id, false, '', '');
            }
        }

        return UnitellerHandler::response($result);
    }

    /**
     * @param array $user
     * @return void
     */
    private function verifyProfileUser(array $user): void
    {
        $unitellerSession = new UnitellerSessionResource([]);
        $calculateProfile = app(UnitellerService::class)->profile()->calculateProfileCompleteness($unitellerSession);

        if ($calculateProfile['isPersonalInfoComplete'] === 'NO') {
            app(UnitellerService::class)->profile()->setupPersonalInfo(new PersonalInfoResource($user));
        }

        if ($calculateProfile['isInformationVerificationComplete'] === 'NO') {
            $result = app(UnitellerService::class)->profile()->informationVerification($unitellerSession);

            UnitellerErrorCode::setErrorCode($result['responseCode']);
            if (UnitellerErrorCode::isSuccess()) {
                $this->profileRepository->setActiveStatus($user['id']);
            }
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|max:20',
        ]);

        if ($validator->fails()) {
            return ResponseHandler::badRequest(ApiErrorCode::REMIT_INVALID_DATA, $validator->errors()->first());
        }

        var_dump($request->all());
        return UnitellerHandler::response(
            app(UnitellerService::class)->security()->changePassword(
                new RemitChangePasswordResource($request->only('password'))
            )
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string',
            'password' => 'string|min:8|max:20|nullable',
            'code' => 'string|digits:6|nullable',
        ]);

        if ($validator->fails()) {
            return ResponseHandler::badRequest(ApiErrorCode::REMIT_INVALID_DATA, $validator->errors()->first());
        }

        $merchant = cache(session('merchant'));
        $service = $merchant['services']['uniteller'];
        $user = $this->userRepository->getByEmailWithRemittance($request->input('email'));

        if (is_null($user)) {
            return ResponseHandler::badRequest(ApiErrorCode::REMIT_INVALID_DATA, __('user.email_not_found'));
        }

        $result = app(UnitellerService::class)->security()->resetPassword(
            new RemitResetPasswordResource($request->all())
        );

        if ($result['responseCode'] === UnitellerErrorCode::SECURITY_QUESTION_ANSWER_REQUIRED) { // SECURITY_QUESTION_ANSWER_REQUIRED
//            $question = (object)[];
//            $question->answer = $user->remittance->answer;
//            $question->questionId = $user->remittance->question_id;
//            $reset_password->setSecurityQuestionAnswers([$question]);

//            $result = $this->security->resetPassword($reset_password, $this->request->platform);

            $result = app(UnitellerService::class)->security()
                ->resetPassword(new RemitResetPasswordResource(
                        [
                            'security_question' => [
                                'answer' => $user->remittance->answer,
                                'questionId' => $user->remittance->question_id,
                            ]
                        ] + $request->validated()
                    )
                );
        }

        if ($result['responseCode'] === UnitellerErrorCode::QUES_ANS_SUCCESS_CODE) { // QUES_ANS_SUCCESS_CODE
//            $reset_password->setSecurityQuestionAnswers(null);
//            $reset_password->setUicReceiptMode(env('UNITELLER_UIC_RECEPTION_METHOD'));
//
//            $result = $this->security->resetPassword($reset_password, $this->request->platform);

            $result = app(UnitellerService::class)->security()
                ->resetPassword(new RemitResetPasswordResource(
                        ['reception_mode' => $service['reception_mode']] + $request->validated()
                    )
                );
        }

        if ($result['responseCode'] === UnitellerErrorCode::UIC_MATCHED_SUCCESS) { // The UIC Match and is success
//            $reset_password->setUic(null);
//            $reset_password->setNewPassword($this->request->new_password);
//
//            $result = $this->security->resetPassword($reset_password, $this->request->platform);

            $result = app(UnitellerService::class)->security()->resetPassword(
                new RemitResetPasswordResource($request->validated())
            );
        }

        if ($result['responseCode'] === UnitellerErrorCode::PROVISIONAL_ACTIVE_USER_CODE) {
            $this->userLogin($request);
        }

        return UnitellerHandler::response($result);
    }

    /**
     * @return string[]
     */
    private function signupRules(): array
    {
        return [
            'privacy_policy_agreement' => 'required|string|in:yes',
            'gender' => 'required|string|in:M,F',
            'birth_date' => 'string|between:8,8',
            'destination_country_iso_code' => 'required|string',
            'address' => 'required|string|between:3,60',
            'zip_code' => 'required|string|between:4,5',
            'security_answer' => 'required|string|between:3,255',
            'security_answer_hint' => 'required|string|between:3,255',
        ];
    }
}
