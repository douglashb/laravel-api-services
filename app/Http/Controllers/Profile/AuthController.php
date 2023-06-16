<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\LoginPostRequest;
use App\Interfaces\Profile\SessionRepository;
use App\Interfaces\Profile\UserLocationRepository;
use App\Interfaces\Profile\UserRepository;
use App\Libraries\ApiErrorCode;
use App\Libraries\MaskData;
use App\Libraries\PageId;
use App\Libraries\ResponseHandler;
use App\Models\Profile\SessionAttempt;
use App\Notifications\AccountLockedMail;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(
        private UserRepository         $userRepository,
        private SessionRepository      $sessionRepository,
        private UserLocationRepository $userLocationRepository
    )
    {
    }

    /**
     * Profile - Login
     *
     * @param LoginPostRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginPostRequest $request): JsonResponse
    {
        $merchant = cache(session('merchant'));
        $user = $this->userRepository->getByEmail($request->input('email'));

        // IF USER NOT EXIST IN DB //
        if ($user === null) {
            return ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, __('email.not_registered'));
        }

        // CHECK IF USER IS DISABLE
        if ($user->disabled) {
            return ResponseHandler::unauthorized(ApiErrorCode::USER_DISABLED, __('user.account_disable', ['phone' => '+' . $merchant['contact_phone']]));
        }

        // CHECK IF USER IS LOCKED
        if ($user->locked) {
            return ResponseHandler::unauthorized(ApiErrorCode::USER_BLOCKED, __('user.account_locked'));
        }

        $session = [
            'user_device_id' => hash('ripemd128', json_encode($request->only(['serial_number', 'email']))),
            'user_remote_address' => $request->input('ip_address'),
            'user_remote_platform' => $request->input('platform'),
        ];

        $token = auth()->claims(['session' => $session])->attempt($request->only(['email', 'password']));
        // ********  FAIL LOGIN - INVALID CREDENTIALS ********
        if (! $token) {
            Log::info('User with email:' . $request->input('email') . ' could not log in - Invalid credentials');

            SessionAttempt::create([
                'profile_user_id' => $user->id,
                'ip_address' => $request->input('ip_address'),
            ]);

            $loginAttempts = SessionAttempt::where('profile_user_id', $user->id)
                ->whereBetween('created_at', [$this->getStartDateToFindAttempts($user->id, $user->lock_at), now()])
                ->get();

            if (count($loginAttempts) === 3) {
                dispatch(function () use ($user) {
                    $user->notify(new AccountLockedMail());
                    $this->userRepository->setLocked($user->id);
                })->afterResponse();

                return ResponseHandler::unauthorized(ApiErrorCode::INVALID_DATA, __('auth.failed') . ' ' . __('user.account_lock'));
            }

            return ResponseHandler::unauthorized(ApiErrorCode::INVALID_DATA, __('auth.failed'));
        }

        // ********  LOGIN SUCCESS ********
        session()->put($session);

        dispatch(function () use ($token, $user) {
            $payload = JWTAuth::setToken($token)->getPayload();
            $this->sessionRepository->updateOrCreate($user->id, $payload->get('iat'));
            $this->userLocationRepository->create($user->id, PageId::LOGIN);
        })->afterResponse();

        if (! $user->active) {
            $sendBy = session('merchant_notify_mode') === 'email' ? MaskData::email($user->email) : MaskData::phone($user->phone);

            Log::info('User with id:' . $user->id . ' need active your account.');

            return ResponseHandler::success(
                __('user.account_need_activation', ['send_by' => $sendBy]),
                $this->bodyToken($token),
                ApiErrorCode::NEED_ACCOUNT_ACTIVATION
            );
        }

        Log::info('User with id:' . $user->id . ' logged in successfully.');

        return ResponseHandler::success(__('user.login_success'), $this->bodyToken($token));
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        if (auth()->check()) {
            $this->sessionRepository->deactivate(auth()->id());
        }

        return ResponseHandler::success(__('user.logout_success'));
    }

    /**
     * @param int $userId
     * @param string|null $dateLocked
     *
     * @return Carbon
     */
    private function getStartDateToFindAttempts(int $userId, ?string $dateLocked): Carbon
    {
        $last24Hours = now()->subDay(); // Default to search Last 24 hours

        if ($dateLocked === null) {
            return $last24Hours;
        }

        $dateLockedParsed = Carbon::parse($dateLocked);
        $LastSession = $this->sessionRepository->getFirstLastDay($userId);

        if ($dateLockedParsed->gt($last24Hours)) {
            if ($LastSession === null) {
                return $dateLockedParsed;
            }

            $lastSessionTime = Carbon::parse($LastSession->created_at);

            if ($lastSessionTime->gt($dateLockedParsed)) {
                return $lastSessionTime;
            }
        }

        return $last24Hours;
    }

    /**
     * @param string $token
     *
     * @return array
     */
    private function bodyToken(string $token): array
    {
        return [
            'access_key' => $token,
            'type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'expiration_type' => 'Inactivity',
        ];
    }
}
