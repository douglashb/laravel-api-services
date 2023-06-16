<?php

namespace App\Services\Uniteller\Classes;

class CurrentExchangeRate extends Base
{
    public string $countryIsoCode;
    public string $currencyIsoCode;

    /**
     * @param string $country_iso_code
     */
    public function setCountryIsoCode(string $country_iso_code): void
    {
        $this->countryIsoCode = $country_iso_code;
    }

    /**
     * @param string $currency_iso_code
     */
    public function setCurrencyIsoCode(string $currency_iso_code): void
    {
        $this->currencyIsoCode = $currency_iso_code;
    }
}
