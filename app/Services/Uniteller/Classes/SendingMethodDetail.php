<?php

namespace App\Services\Uniteller\Classes;

class SendingMethodDetail extends BaseSession
{
    public string $sendingMethodName;
    public string $sendingMethodId;

    /**
     * @param string $sendingMethodName
     */
    public function setSendingMethodName(string $sendingMethodName): void
    {
        $this->sendingMethodName = $sendingMethodName;
    }

    /**
     * @param string $sendingMethodId
     */
    public function setSendingMethodId(string $sendingMethodId): void
    {
        $this->sendingMethodId = $sendingMethodId;
    }
}
