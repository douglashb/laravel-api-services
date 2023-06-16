<?php

namespace App\Services\Uniteller\Classes;

class QuickQuoteExternal extends Base
{
    public string $destCountryISOCode;
    public string $destCurrencyISOCode;
    public float $transactionAmount;
    public string $payerSpecificCode;
    public string $sendingMethodName;
    public int $receptionMethodId;
    public string $receptionMethodName;

    public function setDestCountryIsoCode(string $dest_country_iso_code): void
    {
        $this->destCountryISOCode = $dest_country_iso_code;
    }

    public function setDestCurrencyIsoCode(string $dest_currency_iso_code): void
    {
        $this->destCurrencyISOCode = $dest_currency_iso_code;
    }

    public function setTransactionAmount(float $transaction_amount): void
    {
        $this->transactionAmount = $transaction_amount;
    }

    public function setPayerSpecificCode(string $payer_specific_code): void
    {
        $this->payerSpecificCode = $payer_specific_code;
    }

    public function setSendingMethodName(string $sending_method_name): void
    {
        $this->sendingMethodName = $sending_method_name;
    }

    public function setReceptionMethodId(int $reception_method_id): void
    {
        $this->sendingMethodName = $reception_method_id;
    }

    public function setReceptionMethodName(string $reception_method_name): void
    {
        $this->receptionMethodName = $reception_method_name;
    }
}
