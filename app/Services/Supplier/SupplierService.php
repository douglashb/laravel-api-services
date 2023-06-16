<?php

namespace App\Services\Supplier;

use App\Services\Client;

class SupplierService extends Client
{
    public function __construct(string $urlBase)
    {
        $this->setBaseUri($urlBase);
    }

    /**
     * @return array
     */
    public function getMerchantByApiKey(): array
    {
        return $this->get('/merchants/by-api-key');
    }
}
