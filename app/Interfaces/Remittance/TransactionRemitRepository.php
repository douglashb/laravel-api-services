<?php

namespace App\Interfaces\Remittance;

interface TransactionRemitRepository
{
    public function find(int $userId, string $unitellerId);

    public function create(int $userId, string $sendingMethodId, string $beneficiaryId, array $result);

    public function update(int $userId, array $request, array $result);
}
