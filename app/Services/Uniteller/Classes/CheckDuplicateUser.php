<?php

namespace App\Services\Uniteller\Classes;

class CheckDuplicateUser extends Base
{
    public string $emailAddress;
    public string $firstName;
    public string $lastName;
    public string $birthDate;

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
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->lastName = $last_name;
    }

    /**
     * @param string $birthdate
     */
    public function setBirthDate(string $birthdate): void
    {
        $this->birthDate = $birthdate;
    }
}
