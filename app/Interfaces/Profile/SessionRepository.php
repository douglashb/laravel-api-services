<?php

namespace App\Interfaces\Profile;

interface SessionRepository
{
    public function updateOrCreate(int $userId, string $iat);
    public function getByUserId(int $userId, $datetime);
    public function getFirstLastDay(int $userId);
    public function deactivate(int $userId);
}
