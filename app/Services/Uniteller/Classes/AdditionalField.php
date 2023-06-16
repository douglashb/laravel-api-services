<?php

namespace App\Services\Uniteller\Classes;

class AdditionalField extends Base
{
    public string $payerSpecificCode;
    public string $receptionMethodName;
    public string $currencyISOCode;

    /**
     * @param string $payer_specificCode
     */
    public function setPayerSpecificCode(string $payer_specificCode): void
    {
        $this->payerSpecificCode = $payer_specificCode;
    }

    /**
     * @param string $reception_method_name
     */
    public function setReceptionMethodName(string $reception_method_name): void
    {
        $this->receptionMethodName = $reception_method_name;
    }

    /**
     * @param string $currency_iso_code
     */
    public function setCurrencyIsoCode(string $currency_iso_code): void
    {
        $this->currencyISOCode = $currency_iso_code;
    }
}
