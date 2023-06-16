<?php

namespace App\Services\Uniteller\Classes;

class DeactivateBeneficiary extends BaseSession
{
    public int $beneficiaryId;

    public function setBeneficiaryId(int $beneficiary_id): void
    {
        $this->beneficiaryId = $beneficiary_id;
    }
}
