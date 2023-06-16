<?php

namespace App\Services\Uniteller\Classes;

class AuthenticateSignup extends Base
{
    public string $authenticationCode;
    public string $userId;
    public string $password;

    /**
     * @param string $user_id
     */
    public function setUserId(string $user_id): void
    {
        $this->userId = $user_id;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $authentication_code
     */
    public function setAuthenticationCode(string $authentication_code): void
    {
        $this->authenticationCode = $authentication_code;
    }
}
