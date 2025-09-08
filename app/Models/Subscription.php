<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    /** @use HasFactory<\Database\Factories\SubscriptionFactory> */
    use HasFactory;

    public function price(): HasOne
    {
        return $this->hasOne(PlanPrice::class, 'stripe_price_id', 'stripe_price');
    }

    public function plan(): HasOneThrough
    {
        return $this->hasOneThrough(
            Plan::class,
            PlanPrice::class,
            'stripe_price_id', // Foreign key on PlanPrice table...
            'id', // Foreign key on Plan table...
            'stripe_price', // Local key on Subscription table...
            'plan_id' // Local key on PlanPrice table...
        );
    }
}
