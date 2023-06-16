<?php

namespace App\Interfaces\Remittance;

interface ProfileRemitRepository
{
    public function create(array $profile);

    public function setActiveStatus(int $userId);

    public function setUicStatus(int $userId, bool $isUic, string $responseCode, string $responseMessage);

    public function setLockedStatus(int $userId, bool $isLocked, string $responseCode, string $responseMessage);

    public function get(int $userId);
}
