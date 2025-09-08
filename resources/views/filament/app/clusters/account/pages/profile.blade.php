<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('Personal information') }}
        </x-slot>
        <x-slot name="description">
            {{ __('Update your profile information') }}
        </x-slot>

        <form wire:submit="update" id="profile-form">
            {{ $this->form }}
        </form>

        <x-slot name="footer">
            <x-filament::button type="submit" form-id="profile-form">
                {{ __('Update') }}
            </x-filament::button>
        </x-slot>
    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">
            <span>{{ __('Danger Zone') }}</span>
        </x-slot>
        <x-slot name="description">
            {{ __('Delete your account') }}
        </x-slot>

        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
    </x-filament::section>
</x-filament-panels::page>
