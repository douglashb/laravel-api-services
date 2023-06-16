<?php

namespace App\Repositories\Remittance;

use App\Interfaces\Remittance\ProfileRemitRepository;
use App\Models\Remittance\ProfileRemit;

class ProfileRemitEloquentRepository implements ProfileRemitRepository
{
    public function __construct(
        protected ProfileRemit $model
    ) {
    }

    public function create(array $profile)
    {
        return $this->model->create($profile);
    }

    public function setActiveStatus(int $userId)
    {
        return $this->model->byUserId($userId)->update([
            'active' => true,
            'active_at' => now(),
        ]);
    }

    public function setUicStatus(int $userId, bool $isUic, string $responseCode, string $responseMessage)
    {
        return $this->model->byUserId($userId)->update([
            'error_code' => $responseCode,
            'error_message' => $responseMessage,
            'uic' => $isUic,
            'uic_at' => $isUic ? now() : null,
        ]);
    }

    public function setLockedStatus(int $userId, bool $isLocked, string $responseCode, string $responseMessage)
    {
        return $this->model->byUserId($userId)->update([
            'error_code' => $responseCode,
            'error_message' => $responseMessage,
            'locked' => $isLocked,
            'locked_at' => $isLocked ? now() : null,
        ]);
    }

    public function get(int $userId)
    {
        return $this->model->byUserId($userId)->first();
    }
}
