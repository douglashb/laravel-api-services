<?php

namespace App\Services\IpApi;

use App\Services\Client;

class IpApiService extends Client
{
    public function __construct(string $urlBase)
    {
        $this->setBaseUri($urlBase);
    }

    public function iPGeolocation(string $ip): array
    {
        return $this->get('/' . $ip);
    }
}
