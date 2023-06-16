<?php

namespace App\Services\Uniteller\Classes;

class BankLinkTokenCreate extends BaseSession
{
    public ?int $sendingMethodId = null;

    /**
     * @param int|null $sendingMethodId
     */
    public function setSendingMethodId(?int $sendingMethodId): void
    {
        $this->sendingMethodId = $sendingMethodId;
    }
}
