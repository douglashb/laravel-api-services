<?php

namespace App\Services\Uniteller\Classes;

class ApplyPromotion extends BaseSession
{
    public int $transactionInternalReference;
    public string $promotionCode;

    /**
     * @param int $transaction_internal_reference
     */
    public function setTransactionInternalReference(int $transaction_internal_reference): void
    {
        $this->transactionInternalReference = $transaction_internal_reference;
    }

    /**
     * @param string $promotion_code
     */
    public function setPromotionCode(string $promotion_code): void
    {
        $this->promotionCode = $promotion_code;
    }
}
