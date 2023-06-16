<?php

namespace App\Services\Uniteller\Traits;

use Illuminate\Support\Str;

trait UnitellerAttributes
{
    public static function base(): array
    {
        return [
            'locale' => Str::upper(app()->getLocale()),
            'extraFields' => null,
            'interactionId' => null,
            'partnerCode' => session('remit_partner_code'),
        ];
    }

    public static function baseSession(): array
    {
        return [
            'token' => session('remit_user_token'),
            'userId' => auth()->user()->email,
        ] + self::base();
    }
}
