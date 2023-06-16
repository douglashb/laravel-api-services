<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Remittance\SecurityController;
use App\Http\Requests\Profile\ActivateAccountPostRequest;
use App\Http\Requests\Profile\ChangePasswordPutRequest;
use App\Http\Requests\Profile\ForgotPasswordPostRequest;
use App\Http\Requests\Profile\StoreAccountPostRequest;
use App\Http\Requests\Profile\UpdatePhonePutRequest;
use App\Http\Requests\Remittance\RemitChangePasswordPostRequest;
use App\Http\Requests\Remittance\RemitResetPasswordPutRequest;
use App\Http\Resources\Profile\UserResource;
use App\Http\Resources\Remittance\RemitRequestPasswordResource;
use App\Interfaces\Profile\CodeRepository;
use App\Interfaces\Profile\UserLocationRepository;
use App\Interfaces\Profile\UserRepository;
use App\Libraries\ApiErrorCode;
use App\Libraries\MaskData;
use App\Libraries\PageId;
use App\Libraries\ResponseHandler;
use App\Libraries\UnitellerErrorCode;
use App\Libraries\UnitellerHandler;
use App\Notifications\AccountCreatedMail;
use App\Notifications\ActivationCodeMail;
use App\Notifications\ActivationCodeSms;
use App\Notifications\PasswordChangeCodeMail;
use App\Notifications\PasswordChangeCodeSms;
use App\Notifications\PasswordChangedMail;
use App\Notifications\UserInfoChangedMail;
use App\Services\Uniteller\UnitellerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function __construct(
        private UserRepository         $userRepository,
        private CodeRepository         $codeRepository,
        private UserLocationRepository $userLocationRepository
    )
    {
    }

    /**
     * @param StoreAccountPostRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreAccountPostRequest $request): JsonResponse
    {
        $merchant = cache(session('merchant'));
        $generatedCode = $this->randNumber();

        try {
            $user = $this->userRepository->create($request->validated());
        } catch (\Exception $exception) {
            return ResponseHandler::internalError($exception->getMessage());
        }

        try {
            $this->codeRepository->create([
                'profile_user_id' => $user->id,
                'code' => $generatedCode,
                'mode' => session('merchant_notify_mode') === 'email' ? 1 : 2,
                'profile_page_id' => PageId::ACTIVATION,
            ]);
        } catch (\Exception $exception) {
            return ResponseHandler::internalError($exception->getMessage());
        }

        dispatch(static function () use ($generatedCode, $user) {
            if (session('merchant_notify_mode') === 'email') {
                $user->notify(new ActivationCodeMail($generatedCode));
            } else {
                $user->notify(new AccountCreatedMail());
                $user->notify(new ActivationCodeSms($generatedCode));
            }
        })->afterResponse();

        Log::info('New User with id:' . $user->id . ' has been send an activation code.');

        return ResponseHandler::created(new UserResource($user));
    }

    /**
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        return ResponseHandler::success('Success', new UserResource(auth()->user()));
    }

    /**
     * @param ActivateAccountPostRequest $request
     *
     * @return JsonResponse
     */
    public function activateUpdate(ActivateAccountPostRequest $request): JsonResponse
    {
        $activateCode = $this->codeRepository->getLastActivationCode($request->user()->id);

        if ($activateCode === null ||
            $activateCode->active === 0 ||
            $activateCode->code !== $request->input('code')) {
            return ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, __('code.invalid'));
        }

        $this->userRepository->setActive($request->user()->id);
        $this->codeRepository->deactivate($activateCode->id);
        Log::info('New User with id:' . $request->user()->id . ' has been active.');

        return ResponseHandler::success(__('user.active'));
    }

    /**
     * @param ChangePasswordPutRequest $request
     * @return JsonResponse
     */
    public function passwordUpdate(ChangePasswordPutRequest $request): JsonResponse
    {
        $merchant = cache(session('merchant'));
        $generatedCode = $this->randNumber();
        $changePasswordCode = $this->codeRepository->getLastChangePasswordCode($request->user()->id);

        if ($request->input('code') === null) {
            if ($changePasswordCode === null) {
                $this->codeRepository->create([
                    'profile_user_id' => $request->user()->id,
                    'code' => $generatedCode,
                    'mode' => session('merchant_notify_mode') === 'email' ? 1 : 2,
                    'profile_page_id' => PageId::CHANGED_PASSWORD,
                ]);
            } else {
                $generatedCode = $changePasswordCode->code;
            }

            if (session('merchant_notify_mode') === 'email') {
                $sendBy = MaskData::email($request->user()->email);
                $request->user()->notify(new PasswordChangeCodeMail($generatedCode));
            } else {
                $sendBy = MaskData::phone($request->user()->phone);
                $request->user()->notify(new PasswordChangeCodeSms($generatedCode));
            }

            return ResponseHandler::success(__('code.send', ['value' => $sendBy]));
        }

        if (
            $changePasswordCode === null ||
            ($request->input('code') !== null && $changePasswordCode->code !== $request->input('code'))
        ) {
            return ResponseHandler::badRequest(30, __('code.invalid'));
        }

        if (! is_null($request->user()->remittance)) {
            $result = app(SecurityController::class)->changePassword($request);

            if (! $result->getData()->success) {
                return ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $result->getData()->message);
            }
        }

        $this->userRepository->updatePasswordById($request->user()->id, $request->input('password'));

        if (is_null($request->user()->remittance)) {
            $request->user()->notify(new PasswordChangedMail($merchant));
        }

        return ResponseHandler::success(__('password.changed'));
    }

    /**
     * @param UpdatePhonePutRequest $request
     * @return JsonResponse
     */
    public function phoneUpdate(UpdatePhonePutRequest $request): JsonResponse
    {
        // TODO: send change of phone number to Uniteller
        if (! is_null($request->user()->remittance)) {
        }

        // TODO: send change of phone number to Tern
        if (! is_null($request->user()->tern)) {
        }

        $this->userRepository->updateById($request->user()->id, ['phone' => $request->input('phone')]);

        if (is_null($request->user()->remittance)) {
            $merchant = cache(session('merchant'));
            $request->user()->notify(new UserInfoChangedMail($merchant));
        }

        return ResponseHandler::success(__('user.update_me'), new UserResource($request->user()));
    }

    /**
     * @param ForgotPasswordPostRequest $request
     * @return JsonResponse
     */
    public function passwordForgot(ForgotPasswordPostRequest $request): JsonResponse
    {
        $merchant = cache(session('merchant'));
        $generatedCode = $this->randNumber();
        $user = $this->userRepository->getByEmailWithRemittance($request->input('email'));

        if (! is_null($user->remittance)) {
//            $result = app(SecurityController::class)->resetPassword(new RemitChangePasswordPostRequest());

// TODO: Delete this code before of tests
//            if ($result->code === UnitellerErrorCode::PROVISIONAL_ACTIVE_USER_CODE) {
//                return ResponseHandler::success($result->message);
//            }

//            return UnitellerHandler::response($result);
            return app(SecurityController::class)->resetPassword($request);
        }

        $code = $this->codeRepository->getLastForgotPasswordCode($user->id);
        $this->userLocationRepository->create($user->id, PageId::FORGOT_PASSWORD);

        if ($code !== null) {
            return ResponseHandler::conflict(ApiErrorCode::INVALID_DATA, __('user.forgot_pass_restriction'));
        }

        $this->codeRepository->create([
            'profile_user_id' => $user->id,
            'code' => $generatedCode,
            'mode' => session('merchant_notify_mode') === 'email' ? 1 : 2,
            'profile_page_id' => PageId::FORGOT_PASSWORD,
        ]);

        if (session('merchant_notify_mode') === 'email') {
            $sendBy = MaskData::email($user->email);
            $user->notify(new PasswordChangeCodeMail($generatedCode));
        } else {
            $sendBy = MaskData::phone($user->phone);
            $user->notify(new PasswordChangeCodeSms($merchant, $generatedCode));
        }

        return ResponseHandler::success(__('code.send', ['value' => $sendBy]));
    }

    /**
     * @param RemitResetPasswordPutRequest $request
     * @return JsonResponse
     */
    public function passwordReset(RemitResetPasswordPutRequest $request): JsonResponse
    {
        $user = $this->userRepository->getByEmailWithRemittance($request->input('email'));

        // SEND TO UNITELLER
        if (! is_null($user->remittance)) {
//            $reset_password = new RequestPassword();
//            $reset_password->setUserId($user->id);
//            $reset_password->setPlatform($this->request->platform);
//            $reset_password->setUic($this->request->code);
//            $reset_password->setNewPassword($this->request->password);
//
//            $result = $this->local_remittance->resetPassword($reset_password);
            $result = app(SecurityController::class)->resetPassword(new RemitChangePasswordPostRequest());

            if ($result->getData()->success !== true) {
//                return response()->json($result, $result->getStatusCode());
                return $result;
            }
        } else {
            $code = $this->codeRepository->getLastForgotPasswordCode($user->id);
//            $code = Code::last($user->id, self::$FORGOT_PASSWORD)->first();

            if ($code->code !== $request->input('code')) {
                return ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, __('ext_validation.invalid_code'));
            }

            // Disable Code
//            $code->update(['active' => 0, 'used_at' => now()]);
            $this->codeRepository->deactivate($code->id);
        }

        $this->userRepository->updateById($user->id, [
            'password' => $request->input('password'),
            'auth' => $request->input('password'),
            'locked' => false
        ]);

//        $user->password = $this->request->input('password');
//        $user->auth = $this->request->input('password');
//
//        if ($user->locked === 1) {
//            $user->locked = 0;
//        }
//
//        try {
//            $user->save();
//        } catch (QueryException $e) {
//            return $this->respondInternalError($e->getMessage());
//        }

        if (is_null($user->remittance)) {
            $user->notify(new PasswordChangedMail());

//            $notification = [
//                new NotificationEmail($user->id, self::$PASSWORD_CHANGED)
//            ];
//
//            $this->notificationService->send($notification);
        }

        return ResponseHandler::success(__('password.changed'));
    }

    private function randNumber(): int
    {
        return random_int(100000, 999999);
    }
}
