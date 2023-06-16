<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UniquePhone implements Rule
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
        $phone_clean = str_replace(['+', ' ', '-', '_', '(', ')'], '', $value);

        $query = User::wherePhone($phone_clean)->first();

        if (app()->environment('local', 'develop', 'staging')) {
            return true;
        }

        return $query === null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('phone.unique');
    }
}
