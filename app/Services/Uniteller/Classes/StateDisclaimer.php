<?php

namespace App\Services\Uniteller\Classes;

class StateDisclaimer extends Base
{
    public ?string $stateIsoCode = null;

    /**
     * @param ?string $stateIsoCode
     */
    public function setStateIsoCode(?string $stateIsoCode): void
    {
        $this->stateIsoCode = $stateIsoCode;
    }
}
