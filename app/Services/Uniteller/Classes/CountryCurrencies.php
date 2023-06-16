<?php

namespace App\Services\Uniteller\Classes;

class CountryCurrencies extends Uniteller
{
    public string $countryISOCode;

    /**
     * @param string $country_iso_code
     */
    public function setCountryIsoCode(string $country_iso_code): void
    {
        $this->countryISOCode = $country_iso_code;
    }
}
