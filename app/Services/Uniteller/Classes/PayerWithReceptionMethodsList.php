<?php

namespace App\Services\Uniteller\Classes;

class PayerWithReceptionMethodsList extends Base
{
    public string $countryISOCode;
    public string $currencyISOCode;
    public string $stateISOCode;

    /**
     * @param string $country_iso_code
     */
    public function setCountryIsoCode(string $country_iso_code): void
    {
        $this->countryISOCode = $country_iso_code;
    }

    /**
     * @param string $currency_iso_code
     */
    public function setCurrencyIsoCode(string $currency_iso_code): void
    {
        $this->currencyISOCode = $currency_iso_code;
    }

    /**
     * @param string $state_iso_code
     */
    public function setStateIsoCode(string $state_iso_code): void
    {
        $this->stateISOCode = $state_iso_code;
    }
}
