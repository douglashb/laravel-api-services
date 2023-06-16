<?php

namespace App\Services\Uniteller\Classes;

class ValidateRoutingNumber extends BaseSession
{
    public string $routingNumber;

    /**
     * @param string $routingNumber
     */
    public function setRoutingNumber(string $routingNumber): void
    {
        $this->routingNumber = $routingNumber;
    }
}
