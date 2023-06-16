<?php

namespace App\Interfaces\Remittance;

interface SessionRemitRepository
{
    public function setToken(int $userId, array $responseInfo);
}
