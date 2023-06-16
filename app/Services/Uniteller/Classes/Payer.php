<?php

namespace App\Services\Uniteller\Classes;

class Payer
{
    public ?int $id;

    public ?string $name;
    public ?string $payerSpecificCode;
    public Address $address;
    public ?string $phoneNumber1;
    public ?string $phoneNumber2;
    public ?string $status;
    public ?string $beneAccountRegex;
    public ?string $accountRegexMsg;
    public ?string $isPayerBranchRequired;
    public ?array $receiptionMethod;
}
