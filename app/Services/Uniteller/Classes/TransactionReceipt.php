<?php

namespace App\Services\Uniteller\Classes;

class TransactionReceipt extends BaseSession
{
    public string $transactionNumber;

    public function setTransactionNumber(string $transaction_number): void
    {
        $this->transactionNumber = $transaction_number;
    }
}
