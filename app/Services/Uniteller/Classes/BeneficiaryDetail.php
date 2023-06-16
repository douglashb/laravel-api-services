<?php

namespace App\Services\Uniteller\Classes;

class BeneficiaryDetail extends BaseSession
{
    public int $beneficiaryId;

    /**
     * @param int $beneficiaryId
     */
    public function setBeneficiaryId(int $beneficiaryId): void
    {
        $this->beneficiaryId = $beneficiaryId;
    }
}
