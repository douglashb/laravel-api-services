<?php

namespace App\Models\Remittance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionRemit extends Model
{
    use HasFactory;

    protected $table = 'remittance_sessions';

    protected $fillable = [
        'profile_user_id',
        'token',
        'ip_address',
        'locale',
        'error_code',
        'error_message',
        'updated_at',
    ];

    protected $hidden = [
//        'token',
    ];

    public function scopeUpdatedLessThan($query, $interval)
    {
        return $query->where('updated_at', '>=', now()->subMinutes($interval)->toDateTimeString());
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('profile_user_id', $userId);
    }
}
