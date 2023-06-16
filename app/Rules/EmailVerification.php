<?php

namespace App\Rules;

use App\Services\QuickEmailVerification\QuickEmailVerificationService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\App;

class EmailVerification implements Rule
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
        if (App::environment(['local', 'develop', 'staging'])) {
            return true;
        }

        $response = app(QuickEmailVerificationService::class)->emailVerification($value);

        return isset($response['result']) && $response['result'] === 'valid';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('email.format');
    }
}
