<?php

namespace App\Services\QuickEmailVerification;

use App\Services\Client;

class QuickEmailVerificationService extends Client
{
    private string $publicKey;

    public function __construct(string $urlBase, string $publicKey)
    {
        $this->setBaseUri($urlBase);
        $this->setTypeRequest('query');
        $this->publicKey = $publicKey;
    }

    /**
     * @param string $mail
     *
     * @return array
     */
    public function emailVerification(string $mail): array
    {
        return $this->get('/verify', [
            'email' => $mail,
            'apikey' => $this->publicKey,
        ]);
    }
}
