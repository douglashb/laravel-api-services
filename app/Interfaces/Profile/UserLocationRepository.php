<?php

namespace App\Interfaces\Profile;

interface UserLocationRepository
{
    public function create(int $userId, int $pageId);
}
