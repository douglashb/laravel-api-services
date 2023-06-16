<?php

namespace App\Services\Uniteller\Classes;

class ResendUic extends Base
{
    public string $userId;
    public string $uicReceiptMode;

    /**
     * @param string $uicReceiptMode
     */
    public function setUicReceiptMode(string $uicReceiptMode): void
    {
        $this->uicReceiptMode = $uicReceiptMode;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }
}
