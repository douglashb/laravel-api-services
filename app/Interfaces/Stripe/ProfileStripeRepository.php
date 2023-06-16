<?php

namespace App\Interfaces\Stripe;

use App\Models\Stripe\ProfileStripe;

interface ProfileStripeRepository
{
   public function create(array $info);
}
