<?php

namespace App\Services\Uniteller\Classes;

class SendMoneyPreview extends BaseSession
{
    public string $beneficiaryId;
    public string $sendingMethodId;
    public string $sendingMethodName;
    public string $transactionAmount;
    public ?int $transactionCurrencyId;
    public string $transactionCurrencyISOCode = 'USD';

    /**
     * @param string $beneficiary_id
     */
    public function setBeneficiaryId(string $beneficiary_id): void
    {
        $this->beneficiaryId = $beneficiary_id;
    }

    /**
     * @param string $sending_method_id
     */
    public function setSendingMethodId(string $sending_method_id): void
    {
        $this->sendingMethodId = $sending_method_id;
    }

    /**
     * @param string $sending_method_name
     */
    public function setSendingMethodName(string $sending_method_name): void
    {
        $this->sendingMethodName = $sending_method_name;
    }

    /**
     * @param string $transaction_among
     */
    public function setTransactionAmount(string $transaction_among): void
    {
        $this->transactionAmount = $transaction_among;
    }

    /**
     * @param int $transaction_currency_id
     */
    public function setTransactionCurrencyId(int $transaction_currency_id): void
    {
        $this->transactionCurrencyId = $transaction_currency_id;
    }

    /**
     * @param string $transaction_currency_iso_code
     */
    public function setTransactionCurrencyISOCode(string $transaction_currency_iso_code): void
    {
        $this->transactionCurrencyISOCode = $transaction_currency_iso_code;
    }
}
