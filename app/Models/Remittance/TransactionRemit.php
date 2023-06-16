<?php

namespace App\Models\Remittance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionRemit extends Model
{
    use HasFactory;

    protected $table = 'remittance_transactions';

    protected $fillable = [
        'profile_user_id',
        'uniteller_tx_internal_reference',
        'uniteller_beneficiary_id',
        'uniteller_sending_method_id',
        'uic_required',
        'uic_method',
        'send_method_name',
        'send_method_number',
        'send_method_type',
        'send_currency',
        'send_amount',
        'exchange_rate',
        'service_fee',
        'send_total_amount',
        'payment_currency',
        'payment_amount',
        'reception_method',
        'payment_country_iso',
        'uniteller_tx_number',
        'available_date',
        'status',
        'review',
        'review_at',
        'confirm',
        'confirm_at',
        'canceled',
        'canceled_at',
    ];

    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'uic_required' => 'boolean',
        'confirm' => 'boolean',
    ];

    public function scopeByUser($query, $userId)
    {
        return $query->where('profile_user_id', $userId);
    }

    public function scopeByUniteller($query, $unitellerId)
    {
        return $query->where('uniteller_tx_internal_reference', $unitellerId);
    }
}
