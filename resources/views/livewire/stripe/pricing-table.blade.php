<?php

use Laravel\Cashier\Cashier;
use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        $customer = auth()->user()->syncOrCreateStripeCustomer();
        $session = Cashier::stripe()->customerSessions->create([
            'customer' => $customer->id,
            'components' => ['pricing_table' => ['enabled' => true]],
        ]);

        return [
            'client_reference_id' => $customer->id,
            'customer_session_client_secret' => $session->client_secret,
            'customer_email' => auth()->user()->email
        ];
    }
}

?>

{{-- Layout --}}

<div>
    <script async src="https://js.stripe.com/v3/pricing-table.js"></script>
    <stripe-pricing-table
        pricing-table-id="{{ config('plans.stripe.pricing_table') }}"
        publishable-key="{{ config('cashier.key') }}"
        client-reference-id="{{ $client_reference_id }}"
        customer-session-client-secret="{{ $customer_session_client_secret }}"
    >
    </stripe-pricing-table>
</div>
