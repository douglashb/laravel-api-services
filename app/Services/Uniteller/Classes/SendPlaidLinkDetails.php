<?php

namespace App\Services\Uniteller\Classes;

class SendPlaidLinkDetails extends BaseSession
{
    public string $publicToken;
    public string $institutionId;
    public string $accountId;
    public string $institutionName;

    /**
     * @param string $publicToken
     */
    public function setPublicToken(string $publicToken): void
    {
        $this->publicToken = $publicToken;
    }

    /**
     * @param string $institutionId
     */
    public function setInstitutionId(string $institutionId): void
    {
        $this->institutionId = $institutionId;
    }

    /**
     * @param string $accountId
     */
    public function setAccountId(string $accountId): void
    {
        $this->accountId = $accountId;
    }

    /**
     * @param string $institutionName
     */
    public function setInstitutionName(string $institutionName): void
    {
        $this->institutionName = $institutionName;
    }
}
