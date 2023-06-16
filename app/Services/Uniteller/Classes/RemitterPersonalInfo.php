<?php

namespace App\Services\Uniteller\Classes;

class RemitterPersonalInfo
{
    public string $emailAddress;
    public string $firstName;
    public ?string $middleName = null;
    public string $lastName;
    public ?string $secondLastName = null;
    public string $gender;
    public string $birthDate;
    public string $cellPhone;
    public ?string $workPhone = null;
    public ?string $homePhone = null;
    public Address $address;
    public string $destinationCountryISOCode;
//    public string $optOutUniTeller = 'NO';
    public string $optOutAffiliates = 'NO';
    public string $optOutExternal = 'NO';
    public string $optOutWlp = 'NO';
    public string $preferredLanguage;

    /**
     * @param string $email_address
     */
    public function setEmailAddress(string $email_address): void
    {
        $this->emailAddress = $email_address;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->firstName = $first_name;
    }

    /**
     * @param string|null $middle_name
     */
    public function setMiddleName(?string $middle_name): void
    {
        $this->middleName = $middle_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->lastName = $last_name;
    }

    /**
     * @param string|null $second_last_name
     */
    public function setSecondLastName(?string $second_last_name): void
    {
        $this->secondLastName = $second_last_name;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @param string $birth_date
     */
    public function setBirthDate(string $birth_date): void
    {
        $this->birthDate = $birth_date;
    }

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
     * @param string $destination_country_ISO_code
     */
    public function setDestinationCountryISOCode(string $destination_country_ISO_code): void
    {
        $this->destinationCountryISOCode = $destination_country_ISO_code;
    }

    /**
     * @param string $preferred_language
     */
    public function setPreferredLanguage(string $preferred_language): void
    {
        $this->preferredLanguage = $preferred_language;
    }
}
