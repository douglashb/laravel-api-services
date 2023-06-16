<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    use HasFactory;
    protected $table = 'profile_user_locations';

    protected $fillable = [
        'profile_user_id',
        'profile_page_id',
        'platform',
        'ip_address',
        'serial_number',
        'country',
        'city',
        'zip_code',
        'isp',
    ];

    public function isp(): Attribute
    {
        return Attribute::make(
            set: static fn ($value) => utf8_encode($value)
        );
    }
}
