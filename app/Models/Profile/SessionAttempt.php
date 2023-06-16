<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAttempt extends Model
{
    use HasFactory;

    protected $table = 'profile_session_attempts';

    protected $fillable = [
        'profile_user_id',
        'ip_address',
    ];
}
