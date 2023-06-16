<?php

namespace App\Libraries;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class MaskData
{
    private const SYMBOL_MAK = '•';

    /**
     * @param string $phone
     *
     * @return Stringable
     */
    public static function phone(string $phone): Stringable
    {
        return Str::of($phone)->mask(self::SYMBOL_MAK, -10, 5);
    }

    /**
     * @param string $email
     *
     * @return Stringable
     */
    public static function email(string $email): Stringable
    {
        return Str::of($email)->mask(self::SYMBOL_MAK, -16, 5);
    }
}
