<?php

namespace App\Services\Uniteller\Classes;

class BankAccountLinkInfo extends BaseSession
{
    public string $metaData;
    public ?string $actionData = null;
    public ?string $actionSource = null;
    public ?string $sendingMethodId = null;

    /**
     * @param string $metadata
     */
    public function setMetadata(string $metadata): void
    {
        $this->metaData = $metadata;
    }

    /**
     * @param ?string $actionData
     */
    public function setActionData(?string $actionData): void
    {
        $this->actionData = $actionData;
    }

    /**
     * @param string|null $actionSource
     */
    public function setActionSource(?string $actionSource): void
    {
        $this->actionSource = $actionSource;
    }

    /**
     * @param string|null $sendingMethodId
     */
    public function setSendingMethodId(?string $sendingMethodId): void
    {
        $this->sendingMethodId = $sendingMethodId;
    }
}
