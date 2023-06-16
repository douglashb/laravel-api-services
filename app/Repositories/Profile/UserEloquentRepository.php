<?php

namespace App\Repositories\Profile;

use App\Interfaces\Profile\UserRepository;
use App\Models\User;

class UserEloquentRepository implements UserRepository
{
    public function __construct(
        protected User $model
    ) {
    }

    public function getById($userId)
    {
        return $this->model->find($userId);
    }

    public function getByEmail(string $email)
    {
        return $this->model->firstWhere('email', $email);
    }

    public function create(array $userInfo)
    {
        return $this->model->create($userInfo + [
            'profile_country_id' => 1,
            'api_merchant_id' => 1,
            'auth' => $userInfo['password'],
        ]);
    }

    public function updateById(int $userId, array $newInfo)
    {
        return $this->model->find($userId)->update($newInfo);
    }

    public function updatePasswordById(int $userId, string $password)
    {
        return $this->model->find($userId)->update([
            'password' => $password,
            'auth' => $password,
        ]);
    }

    public function setActive(int $userId)
    {
        return $this->model->find($userId)->update([
            'active' => true,
            'active_at' => now(),
        ]);
    }

    public function setLocked(int $userId) {
        return $this->model->find($userId)->update([
            'locked' => true,
            'locked_at' => now(),
        ]);
    }

    public function getByEmailWithRemittance(string $email) {
        return $this->model->with('remittance')->firstWhere('email', $email);
    }
}
