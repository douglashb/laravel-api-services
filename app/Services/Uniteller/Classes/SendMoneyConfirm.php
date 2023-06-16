<?php

namespace App\Services\Uniteller\Classes;

class SendMoneyConfirm extends Uniteller
{
    public string $token;
    public string $userId;
    public int $transactionInternalReference;
    public ?string $promotionCode = null;
    public ?string $uicReceiptMode = null;
    public ?string $uic = null;

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @param string $user_id
     */
    public function setUserId(string $user_id): void
    {
        $this->userId = $user_id;
    }

    /**
     * @param int $transactionInternalReference
     */
    public function setTransactionInternalReference(int $transactionInternalReference): void
    {
        $this->transactionInternalReference = $transactionInternalReference;
    }

    /**
     * @param string $promotion_code
     */
    public function setPromotionCode(string $promotion_code): void
    {
        $this->promotionCode = $promotion_code;
    }

    /**
     * @param string $uic_receipt_mode
     */
    public function setUidReceiptMode(string $uic_receipt_mode): void
    {
        $this->uicReceiptMode = $uic_receipt_mode;
    }

    /**
     * @param string $uic
     */
    public function setUic(string $uic): void
    {
        $this->uic = $uic;
    }
}
