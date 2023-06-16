<?php

namespace App\Interfaces\Profile;

interface UserRepository
{
    public function getById(int $userId);
    public function getByEmail(string $email);
    public function create(array $userInfo);
    public function updateById(int $userId, array $newInfo);
    public function updatePasswordById(int $userId, string $password);
    public function setActive(int $userId);
    public function setLocked(int $userId);
    public function getByEmailWithRemittance(string $email);
}
