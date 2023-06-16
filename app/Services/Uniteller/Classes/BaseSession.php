<?php

namespace App\Services\Uniteller\Classes;

class BaseSession extends Base
{
    public string $token;
    public string $userId;

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }
}
