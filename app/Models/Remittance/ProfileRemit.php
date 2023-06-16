<?php

namespace App\Models\Remittance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileRemit extends Model
{
    use HasFactory;

    protected $table = 'remittance_profiles';

    protected $fillable = [
        'profile_user_id',
        'gender',
        'birth_date',
        'destination_country_iso_code',
        'address',
        'country',
        'country_iso_code',
        'zip_code',
        'question_id',
        'answer',
        'active',
        'uic',
        'locked',
        'error_code',
        'error_message',
        'active_at',
        'locked_at',
    ];

    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'locked' => 'boolean',
        'uic' => 'boolean',
        'active' => 'boolean',
    ];

    public function scopeByUserId($query, int $userId)
    {
        return $query->where('profile_user_id', $userId);
    }
}
