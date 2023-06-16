<?php

namespace App\Services\Uniteller;

use App\Services\Client;
use App\Services\Uniteller\Types\Common;
use App\Services\Uniteller\Types\ProfileManagement;
use App\Services\Uniteller\Types\Remittance;
use App\Services\Uniteller\Types\Security;

class UnitellerService extends Client
{
    public function __construct(string $uri, array $headers)
    {
        $this->setBaseUri($uri);
        $this->setHeaders(['uniteller-headers' => json_encode($headers)]);
    }

    /**
     * @return Common
     */
    public function common(): Common
    {
        return new Common($this);
    }

    public function profile(): ProfileManagement
    {
        return new ProfileManagement($this);
    }

    public function security(): Security
    {
        return new Security($this);
    }

    public function remittance(): Remittance
    {
        return new Remittance($this);
    }
}
