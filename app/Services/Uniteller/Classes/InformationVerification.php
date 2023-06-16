<?php

namespace App\Services\Uniteller\Classes;

class InformationVerification extends BaseSession
{
    public ?string $sSN = null;
    public array $verificationQuestionAnswer = [];
    public string $canNotSsnProvide = 'Yes';
}
