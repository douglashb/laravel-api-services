<?php

namespace App\Services\Uniteller\Classes;

class SendAuthenticationCodeAgain extends Base
{
    public string $userId;

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }
}
