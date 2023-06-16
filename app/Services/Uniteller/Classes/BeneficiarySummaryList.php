<?php

namespace App\Services\Uniteller\Classes;

class BeneficiarySummaryList extends BaseSession
{
    public ?string $partialOrFull;

    /**
     * @param string $partial_or_full
     */
    public function setPartialOrFull(string $partial_or_full = 'F'): void
    {
        $this->partialOrFull = $partial_or_full;
    }
}
