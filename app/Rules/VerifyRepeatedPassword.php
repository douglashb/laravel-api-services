<?php

namespace App\Rules;

use App\Models\Profile\PasswordHistory;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class VerifyRepeatedPassword implements Rule
{
    protected ?string $email;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(?string $email = null)
    {
        $this->email = $email;
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
        if ($this->email === null && auth()->check()) {
            $user = auth()->user();
        } else {
            $user = User::firstWhere('email', $this->email);
        }

        if ($user === null) {
            return false;
        }

        $passwordHistory = (new PasswordHistory())->getLastPasswordsUser($user->id);
        foreach ($passwordHistory as $ph) {
            if (Hash::check($value, $ph->password)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('password.repeat', ['value' => config('internal.password.history_keep')]);
    }
}
