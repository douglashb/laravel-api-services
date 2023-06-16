<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidatePassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (bool) preg_match('/(?=^.{8,20}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).*$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('password.validate');
    }
}
