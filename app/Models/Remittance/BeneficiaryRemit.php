<?php

namespace App\Models\Remittance;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BeneficiaryRemit extends Model
{
    use HasFactory;

    protected $table = 'remittance_beneficiaries';

    protected $fillable = [
        'profile_user_id',
        'uniteller_beneficiary_id',
        'first_name',
        'middle_name',
        'first_lastname',
        'second_lastname',
        'cell_phone',
        'reception_method',
        'dest_country_iso_code',
        'dest_currency_iso_code',
        'payer_name',
        'country',
        'active',
        'error_code',
        'error_message',
        'deactivated_at',
    ];

    protected $hidden = [
        'id',
        'error_code',
        'error_message',
        'deactivated_at',
    ];

    public function scopeByUser($query, $userId)
    {
        return $query->where('profile_user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(
            set: static fn ($value) => Str::ucfirst(Str::lower($value)),
        );
    }

    protected function middleName(): Attribute
    {
        return Attribute::make(
            set: static fn ($value) => Str::ucfirst(Str::lower($value)),
        );
    }

    protected function firstLastName(): Attribute
    {
        return Attribute::make(
            set: static fn ($value) => Str::ucfirst(Str::lower($value)),
        );
    }

    protected function secondLastName(): Attribute
    {
        return Attribute::make(
            set: static fn ($value) => Str::ucfirst(Str::lower($value)),
        );
    }
}
