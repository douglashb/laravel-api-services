<?php

namespace App\Services\Uniteller\Classes;

class Address
{
    public ?string $address1 = null;
    public ?string $address2 = '';
    public ?string $city = null;
    public ?string $country = '';
    public ?string $countryISOCode = null;
    public ?string $state = null;
    public ?string $stateName = '';
    public ?string $zipCode = null;

    /**
     * @param string $address_1
     */
    public function setAddress1(string $address_1): void
    {
        $this->address1 = $address_1;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @param string $country_iso_code
     */
    public function setCountryISOCode(string $country_iso_code): void
    {
        $this->countryISOCode = $country_iso_code;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @param string $state_name
     */
    public function setStateName(string $state_name): void
    {
        $this->stateName = $state_name;
    }

    /**
     * @param string $zip_code
     */
    public function setZipCode(string $zip_code): void
    {
        $this->zipCode = $zip_code;
    }
}
