<?php

namespace App\Services\Uniteller\Classes;

class AddSendingMethod extends BaseSession
{
    public string $sendingMethodName;
    public ?string $bankName = null;
    public ?string $accountType = null;
    public ?string $routingNumber = null;
    public ?string $accountNumber = null;
    public ?string $cardType = null;
    public ?string $cardNumber = null;
    public ?string $expireDate = null;
    public ?string $cvvNumber = null;
    public Address $billingAddress;
    public string $billingPhone;
    public string $allowCreditDebitTwoAmounts = 'YES';
    public ?string $nickName = null;

    /**
     * @param string $sendingMethodName
     */
    public function setSendingMethodName(string $sendingMethodName): void
    {
        $this->sendingMethodName = $sendingMethodName;
    }

    /**
     * @param string|null $bankName
     */
    public function setBankName(?string $bankName): void
    {
        $this->bankName = $bankName;
    }

    /**
     * @param string|null $accountType
     */
    public function setAccountType(?string $accountType): void
    {
        $this->accountType = $accountType;
    }

    /**
     * @param string|null $accountNumber
     */
    public function setAccountNumber(?string $accountNumber): void
    {
        $this->accountNumber = $accountNumber;
    }

    /**
     * @param string|null $routingNumber
     */
    public function setRoutingNumber(?string $routingNumber): void
    {
        $this->routingNumber = $routingNumber;
    }

    /**
     * @param string|null $cardType
     */
    public function setCardType(?string $cardType): void
    {
        $this->cardType = $cardType;
    }

    /**
     * @param string|null $cardNumber
     */
    public function setCardNumber(?string $cardNumber): void
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * @param string|null $cvvNumber
     */
    public function setCvvNumber(?string $cvvNumber): void
    {
        $this->cvvNumber = $cvvNumber;
    }

    /**
     * @param Address $billingAddress
     */
    public function setBillingAddress(Address $billingAddress): void
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @param string $billingPhone
     */
    public function setBillingPhone(string $billingPhone): void
    {
        $this->billingPhone = $billingPhone;
    }

    /**
     * @param string|null $expireDate
     */
    public function setExpireDate(?string $expireDate): void
    {
        $this->expireDate = $expireDate;
    }
}
