<?php

namespace App\Services\Uniteller\Classes;

class CancelTransaction extends BaseSession
{
    public string $transactionNumber;
    public string $reasonforCancel = 'Other';
    public ?string $comments = null;

    /**
     * @param string $transaction_number
     */
    public function setTransactionNumber(string $transaction_number): void
    {
        $this->transactionNumber = $transaction_number;
    }

    /**
     * @param string $reason_for_cancel
     */
    public function setReasonForCancel(string $reason_for_cancel): void
    {
        $this->reasonforCancel = $reason_for_cancel;
    }

    /**
     * @param string $comments
     */
    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }
}
