<?php

namespace App\Services\Uniteller\Classes;

class EditUserProfile extends BaseSession
{
    public RemitterPersonalInfo $remitterInfo;

    /**
     * @param RemitterPersonalInfo $remitterInfo
     */
    public function setRemitterInfo(RemitterPersonalInfo $remitterInfo): void
    {
        $this->remitterInfo = $remitterInfo;
    }
}
