<?php

namespace App\Interfaces\Remittance;

interface BeneficiaryRemitRepository
{
    public function all(int $userId);

    public function create(int $userId, array $result);

    public function delete(int $beneficiaryId);
}
