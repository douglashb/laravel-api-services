<?php

namespace App\Services\Uniteller\Classes;

use Illuminate\Support\Str;

class Base
{
    public string $locale;
    public ?array $extraFields = null;
    public ?string $interactionId = null;
    public string $partnerCode = 'PAYVMS';

    /**
     * @param string $value
     *
     * @return void
     */
    public function setPartnerCode(string $value): void
    {
        $this->partnerCode = $value;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = Str::upper($locale);
    }

    /**
     * @param array|null $extraFields
     */
    public function setExtraFields(?array $extraFields): void
    {
        $this->extraFields = $extraFields;
    }

    /**
     * @param string|null $interactionId
     */
    public function setInteractionId(?string $interactionId): void
    {
        $this->interactionId = $interactionId;
    }
}
