<?php

namespace App\Repositories\Profile;

use App\Interfaces\Profile\SessionRepository;
use App\Models\Profile\Session;
use Carbon\Carbon;

class SessionEloquentRepository implements SessionRepository
{
    public function __construct(
        protected Session $model
    ) {
    }

    public function updateOrCreate(int $userId, string $iat)
    {
        $this->model->updateOrCreate(
            [
                'profile_user_id' => $userId,
            ],
            [
                'locale' => app()->getLocale(),
                'iat' => $iat,
                'last_login_at' => Carbon::now(),
                'last_activity_at' => Carbon::now(),
                'active' => 1,
            ]
        );
    }

    public function getByUserId(int $userId, $datetime)
    {
        return $this->model->firstWhere([
            ['profile_user_id', $userId],
            ['created_at', '>', $datetime],
        ]);
    }

    public function getFirstLastDay(int $userId)
    {
        return $this->model->firstWhere([
            ['profile_user_id', $userId],
            ['created_at', '>', now()->subDay()],
        ]);
    }

    public function deactivate(int $userId) {
        return $this->model->byUser($userId)->update([
            'active' => false,
        ]);
    }
}
