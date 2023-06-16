<?php

namespace App\Services\Uniteller\Classes;

class PayerBranches extends Base
{
    public string $payerSpecificCode;
    public string $countryISOCode;
    public string $currencyISOCode;
    public string $receptionMethodName;
    public string $stateISOCode;
    public ?string $city = null;
    public ?string $address = null;

    /**
     * @param string $payer_specific_code
     */
    public function setPayerSpecificCode(string $payer_specific_code): void
    {
        $this->payerSpecificCode = $payer_specific_code;
    }

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
     * @param string $reception_method_name
     */
    public function setReceptionMethodName(string $reception_method_name): void
    {
        $this->receptionMethodName = $reception_method_name;
    }

    /**
     * @param string $state_iso_code
     */
    public function setStateIsoCode(string $state_iso_code): void
    {
        $this->stateISOCode = $state_iso_code;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
}
