<?php

namespace App\Repositories\Profile;

use App\Interfaces\Profile\CodeRepository;
use App\Libraries\PageId;
use App\Models\Profile\Code;

class CodeEloquentRepository implements CodeRepository
{
    public function __construct(
        protected Code $model
    ) {
    }

    public function getById($codeId)
    {
        return $this->model->find($codeId);
    }

    public function create(array $codeInfo)
    {
        return $this->model->create($codeInfo);
    }

    public function update($codeId, array $newInfo)
    {
        return $this->model->whereId($codeId)->update($newInfo);
    }

    public function getLastActivationCode(int $userId)
    {
        return $this->model->getLastActivationCode($userId);
    }

    public function getLastChangePasswordCode(int $userId)
    {
        return $this->model->getLastChangePasswordCode($userId);
    }

    public function getLastForgotPasswordCode(int $userId) {
        return $this->model->getLastForgotPasswordCode($userId);
    }

    public function deactivate(int $codeId)
    {
        return $this->model->find($codeId)->update([
            'active' => false,
            'used_at' => now()
        ]);
    }
}
