<?php

namespace App\Services\Uniteller\Classes;

class AddBeneficiary extends BaseSession
{
    public BeneficiarySummary $beneficiarySummary;

    /**
     * @param BeneficiarySummary $beneficiary_summary
     */
    public function setBeneficiarySummary(BeneficiarySummary $beneficiary_summary): void
    {
        $this->beneficiarySummary = $beneficiary_summary;
    }
}
