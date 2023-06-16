<?php

namespace App\Services\Uniteller\Types;

use App\Http\Resources\Remittance\RemitAutenticateSignupResource;
use App\Http\Resources\Remittance\RemitChangePasswordResource;
use App\Http\Resources\Remittance\RemitRequestPasswordResource;
use App\Http\Resources\Remittance\RemitResetPasswordResource;
use App\Http\Resources\Remittance\RemitSignupResource;
use App\Services\Uniteller\Classes\AuthenticateSignup;
use App\Services\Uniteller\Classes\ChangePassword;
use App\Services\Uniteller\Classes\CheckDuplicateUser;
use App\Services\Uniteller\Classes\Logout;
use App\Services\Uniteller\Classes\ResendUic;
use App\Services\Uniteller\Classes\ResetPassword;
use App\Services\Uniteller\Classes\SendAuthenticationCodeAgain;
use App\Services\Uniteller\Classes\Signup;
use App\Services\Uniteller\Classes\UserLogin;
use App\Services\Uniteller\UnitellerService;

class Security
{
    public function __construct(
        private UnitellerService $service
    ) {
    }

    /**
     * Signup
     *
     * #[Route("Security/v2/Signup", methods: ["POST"])]
     *
     * @param RemitSignupResource $signup
     *
     * @return array
     */
    public function signup(RemitSignupResource $signup): array
    {
        return $this->service->post('/Security/v2/Signup', $signup->jsonSerialize());
    }

    /**
     * User Login
     *
     * #[Route("Security/v2/UserLogin", methods: ["POST"])]
     *
     * @param UserLogin $userLogin
     *
     * @return array
     */
    public function userLogin(UserLogin $userLogin): array
    {
        return $this->service->post('/Security/v2/UserLogin', $userLogin);
    }

    /**
     * Authenticate Signup
     *
     * #[Route("Security/v2/AuthenticateSignup", methods: ["POST"])]
     *
     * @param RemitAutenticateSignupResource $authenticateSignup
     *
     * @return array
     */
    public function authenticateSignup(RemitAutenticateSignupResource $authenticateSignup): array
    {
        return $this->service->post('/Security/v2/AuthenticateSignup', $authenticateSignup->jsonSerialize());
    }

    /**
     * Logout
     *
     * #[Route("Security/LogOut", methods: ["POST"])]
     *
     * @param Logout $logout
     *
     * @return array
     */
    public function logOut(Logout $logout): array
    {
        return $this->service->post('/Security/LogOut', $logout);
    }

    /**
     * Reset Password
     *
     * #[Route("Security/v2_1/ResetPassword", methods: ["POST"])]
     *
     * @param RemitResetPasswordResource $resetPassword
     *
     * @return array
     */
    public function resetPassword(RemitResetPasswordResource $resetPassword): array
    {
        return $this->service->post('/Security/v2_1/ResetPassword', $resetPassword->jsonSerialize());
    }

    /**
     * Change Password
     *
     * #[Route("Security/ChangePassword", methods: ["POST"])]
     *
     * @param RemitChangePasswordResource $changePassword
     *
     * @return array
     */
    public function changePassword(RemitChangePasswordResource $changePassword): array
    {
        return $this->service->post('/Security/ChangePassword', $changePassword->jsonSerialize());
    }

    /**
     * Check Duplicate User
     *
     * #[Route("Security/CheckDuplicateUser", methods: ["POST"])]
     *
     * @param CheckDuplicateUser $checkDuplicateUser
     *
     * @return array
     */
    public function checkDuplicateUser(CheckDuplicateUser $checkDuplicateUser): array
    {
        return $this->service->post('/Security/CheckDuplicateUser', $checkDuplicateUser);
    }

    /**
     * Resend Uic
     *
     * #[Route("Security/v2/ResendUic", methods: ["POST"])]
     *
     * @param ResendUic $resendUic
     *
     * @return array
     */
    public function resendUic(ResendUic $resendUic): array
    {
        return $this->service->post('/Security/v2/ResendUic', $resendUic);
    }

    /**
     * Send Authentication Code Again
     *
     * #[Route("Security/SendAuthenticationCodeAgain", methods: ["POST"])]
     *
     * @param SendAuthenticationCodeAgain $authenticationCodeAgain
     *
     * @return array
     */
    public function sendAuthenticationCodeAgain(SendAuthenticationCodeAgain $authenticationCodeAgain): array
    {
        return $this->service->post('/Security/SendAuthenticationCodeAgain', $authenticationCodeAgain);
    }
}
