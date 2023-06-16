<?php

namespace App\Rules;

use App\Models\User;
use CodeInc\StripAccents\StripAccents;
use Illuminate\Contracts\Validation\Rule;

class NamesInPassword implements Rule
{
    private array|object $userInfo;
    private array $searchValues = ['first_name', 'middle_name', 'first_last_name', 'second_last_name', 'phone', 'province_state'];
    private ?string $userEmail;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userInfo, ?string $userEmail = null)
    {
        $this->userInfo = $userInfo;
        $this->userEmail = $userEmail;
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
        if($this->userEmail !== null) {
            $this->userInfo = User::firstWhere('email', $this->userEmail);
        }

        foreach ($this->searchValues as $key) {
            $info = is_array($this->userInfo) ? $this->userInfo[$key] : $this->userInfo->$key;

            if (empty($info)) {
                continue;
            }

            if (stripos($value, $info) !== false || stripos($value, StripAccents::strip($info)) !== false) {
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
        return __('password.no_info');
    }
}
