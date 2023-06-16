<?php

namespace App\Repositories\Remittance;

use App\Interfaces\Remittance\SessionRemitRepository;
use App\Models\Remittance\SessionRemit;

class SessionRemitEloquentRepository implements SessionRemitRepository
{
    public function __construct(
        protected SessionRemit $model
    ) {
    }

    public function setToken(int $userId, array $responseInfo)
    {
        return $this->model->updateOrCreate([
            'profile_user_id' => $userId,
        ], [
            'token' => $responseInfo['token'],
            'ip_address' => session('user_remote_address'),
            'locale' => app()->getLocale(),
            'error_code' => $responseInfo['responseCode'],
            'error_message' => $responseInfo['responseMessage'],
            'updated_at' => now(),
        ]);
    }
}
