<?php

namespace App\Services\Country;

use App\Services\Client;

class CountryService extends Client
{
    public function __construct(string $urlBase, array $headers)
    {
        $this->setBaseUri($urlBase);
        $this->setHeaders($headers);
    }

    /**
     * @param string $stateIsoCode
     * @return array
     */
    public function getStates(string $countryIsoCode): array
    {
        return $this->get('/v1/countries/' . $countryIsoCode . '/states');
    }

    public function getCities(string $countryIsoCode, string $stateIsoCode): array
    {
        return $this->get('/v1/countries/' . $countryIsoCode . '/states/' . $stateIsoCode . '/cities');
    }
}
