<?php

namespace App\Listeners;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Events\WebhookReceived;

class ManageUserRoleOnSubscriptions implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        $events = ['customer.subscription.created', 'customer.subscription.updated', 'customer.subscription.deleted'];

        if (!in_array($event->payload['type'], $events)) {
            return;
        }

        $customer = $event->payload['data']['object']['customer'] ?? null;
        $productId = $event->payload['data']['object']['plan']['product'] ?? null;
        $user = User::query()->where('stripe_id', $customer)->first();
        $role = Plan::query()->where('stripe_product_id', $productId)->first()?->role;

        match ($event->payload['type']) {
            'customer.subscription.created', 'customer.subscription.updated' => $user?->syncRoles($role),
            'customer.subscription.deleted' => $user?->syncRoles(null),
            default => null,
        };
    }
}
