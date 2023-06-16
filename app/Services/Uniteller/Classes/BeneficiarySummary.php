<?php

namespace App\Services\Uniteller\Classes;

use Illuminate\Support\Str;

class BeneficiarySummary
{
    public ?int $id = null;
    public ?string $gender;
    public ?string $emailId = null;
    public ?string $firstName;
    public ?string $midName = null;
    public ?string $lastName;
    public ?string $secLastName = null;
    public ?string $nickName = null;
    public ?string $accHolderName = null;
    public ?string $accNumber = null;
    public ?string $accType = null;

    public Address $address;
    public ?string $beneDOB = null;
    public ?string $homePhone = null;
    public string $cellPhone;
    public ?string $workPhone = null;
    public ?string $beneStatus = null;
    public string $payer;
    public ?string $receptionMethod;
    public ?string $destinationCurrency = null;
    public ?string $destCountryISOCode;
    public ?string $destCurrencyISOCode = null;
    public string $payerSpecificCode;
    public ?string $payerBranchCode = null;
    public ?string $beneVerification = null;
    public ?Payer $payerInfo = null;
    public ?array $additionalFieldInfo = null;
    public ?string $isCurpVerified = null;

    /**
     * @required
     */
    public ?string $contactType;

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = Str::ucfirst(Str::lower($firstName));
    }

    /**
     * @param string|null $midMame
     */
    public function setMidName(?string $midMame): void
    {
        $this->midName = $midMame === null ? $midMame : Str::ucfirst(Str::lower($midMame));
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name): void
    {
        $this->lastName = Str::ucfirst(Str::lower($last_name));
    }

    /**
     * @param string|null $secLastName
     */
    public function setSecLastName(?string $secLastName): void
    {
        $this->secLastName = $secLastName === null ? $secLastName : Str::ucfirst(Str::lower($secLastName));
    }

    /**
     * @param string|null $nickName
     */
    public function setNickName(?string $nickName): void
    {
        $this->nickName = $nickName;
    }

    /**
     * @param string|null $acc_holder_name
     */
    public function setAccHolderName(?string $acc_holder_name): void
    {
        $this->accHolderName = $acc_holder_name;
    }

    /**
     * @param string|null $acc_number
     */
    public function setAccNumber(?string $acc_number): void
    {
        $this->accNumber = $acc_number;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @param string|null $bene_dob
     */
    public function setBeneDOB(?string $bene_dob): void
    {
        $this->beneDOB = $bene_dob;
    }

    /**
     * @param string $cell_phone
     */
    public function setCellPhone(string $cell_phone): void
    {
        $this->cellPhone = $cell_phone;
    }

    /**
     * @param string $payer
     */
    public function setPayer(string $payer): void
    {
        $this->payer = $payer;
    }

    /**
     * @param string|null $reception_method
     */
    public function setReceptionMethod(?string $reception_method): void
    {
        $this->receptionMethod = $reception_method;
    }

    /**
     * @param string|null $destination_currency
     */
    public function setDestinationCurrency(?string $destination_currency): void
    {
        $this->destinationCurrency = $destination_currency;
    }

    /**
     * @param string $destination_country_iso_code
     */
    public function setDestCountryISOCode(string $destination_country_iso_code): void
    {
        $this->destCountryISOCode = $destination_country_iso_code;
    }

    /**
     * @param string $dest_currency_iso_code
     */
    public function setDestCurrencyISOCode(string $dest_currency_iso_code): void
    {
        $this->destCurrencyISOCode = $dest_currency_iso_code;
    }

    /**
     * @param string $payer_specific_code
     */
    public function setPayerSpecificCode(string $payer_specific_code): void
    {
        $this->payerSpecificCode = $payer_specific_code;
    }

    /**
     * @param string|null $payer_branch_code
     */
    public function setPayerBranchCode(?string $payer_branch_code): void
    {
        $this->payerBranchCode = $payer_branch_code;
    }

    /**
     * @param string $bene_verification
     */
    public function setBeneVerification(string $bene_verification): void
    {
        $this->beneVerification = $bene_verification;
    }

    /**
     * @param Payer|null $payer
     */
    public function setPayerInfo(?Payer $payer): void
    {
        $this->payerInfo = $payer;
    }

    public function setAdditionalFieldInfo($additional_field_info): void
    {
        $this->additionalFieldInfo = $additional_field_info;
    }

    /**
     * @param string|null $contact_type
     */
    public function setContactType(?string $contact_type): void
    {
        $this->contactType = $contact_type;
    }
}
