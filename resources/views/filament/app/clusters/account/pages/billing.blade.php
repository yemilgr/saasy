@php use Filament\Support\Icons\Heroicon; @endphp
<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('Subscription') }}
        </x-slot>

        <x-slot name="afterHeader">
            @if($current)
                <x-filament::button outlined="true" wire:click="billingPortal">
                    {{ __('Manage your subscription') }}
                </x-filament::button>
            @endif
        </x-slot>

        <x-slot name="description">
            {{ __('Your subscription details') }}
        </x-slot>

        {{-- BODY --}}
        @if(!$current)
            <div class="flex justify-center">
                <x-filament::badge color="warning" size="lg" class="p-4 my-6">
                    {{ __("You're not subscribed to :app yet. To subscribe to any of our plans, click the button below.", ["app" => config('app.name')]) }}
                </x-filament::badge>
            </div>

            <livewire:stripe.pricing-table/>
        @else
            <x-filament::badge color="primary" size="lg" class="p-4 font-light">
                {{ __("You're currently subscribed to plan:", ) }}: <strong class="uppercase font-bold">{{ $current->plan->name }}</strong>
            </x-filament::badge>
        @endif
        {{-- END BODY --}}
    </x-filament::section>

    {{-- Invoice table --}}
    {{ $this->table }}
</x-filament-panels::page>
