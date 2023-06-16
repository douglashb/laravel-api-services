<?php

namespace App\Services\Uniteller\Classes;

class SetupPersonalInfo extends BaseSession
{
    public string $cellPhone;
    public string $workPhone = '';
    public string $homePhone = '';
    public Address $address;
    public ?string $preferredLanguage = null;
    public string $gender;
    public ?string $sSN = null;

    /**
     * @param string $cell_phone
     */
    public function setCellPhone(string $cell_phone): void
    {
        $this->cellPhone = $cell_phone;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function setPreferredLanguage(string $preferred_language): void
    {
        $this->preferredLanguage = $preferred_language;
    }
}
