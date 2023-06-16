<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{
    use HasFactory;

    protected $table = 'profile_password_history';

    protected $fillable = [
        'profile_user_id',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * @param int $userId
     *
     * @return mixed
     */
    public function getLastPasswordsUser($userId)
    {
        return $this->where('profile_user_id', $userId)
            ->latest()
            ->take(config('internal.password.history_keep'))
            ->get();
    }
}
