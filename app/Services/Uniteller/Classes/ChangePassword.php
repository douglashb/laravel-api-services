<?php

namespace App\Services\Uniteller\Classes;

class ChangePassword extends Base
{
    public string $currentPassword;
    public string $newPassword;
    public string $userId;

    public function setUserId(string $user_id): void
    {
        $this->userId = $user_id;
    }

    public function setCurrentPassword(string $current_password): void
    {
        $this->currentPassword = $current_password;
    }

    public function setNewPassword(string $new_password): void
    {
        $this->newPassword = $new_password;
    }
}
