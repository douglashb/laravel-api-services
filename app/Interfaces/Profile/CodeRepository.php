<?php

namespace App\Interfaces\Profile;

interface CodeRepository
{
    public function getById($codeId);
    public function create(array $codeInfo);
    public function update($codeId, array $newInfo);
    public function getLastActivationCode(int $userId);
    public function getLastChangePasswordCode(int $userId);
    public function getLastForgotPasswordCode(int $userId);
    public function deactivate(int $codeId);
}
