<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $table = 'profile_sessions';

    protected $fillable = [
        'profile_user_id',
        'locale',
        'iat',
        'last_login_at',
        'last_activity_at',
        'active',
    ];


    public function scopeByUser($query, $userId)
    {
        return $query->where('profile_user_id', $userId);
    }
}
