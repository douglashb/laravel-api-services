<?php

namespace App\Models\Stripe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileStripe extends Model
{
    use HasFactory;

    protected $table = 'stripe_profiles';

    protected $fillable = [
        'profile_user_id',
        'stripe_id'
    ];
}
