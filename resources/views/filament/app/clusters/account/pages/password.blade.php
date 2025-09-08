<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('Password change') }}
        </x-slot>
        <x-slot name="description">
            {{ __('Change your account password') }}
        </x-slot>

        <form wire:submit="update" id="password-form">
            {{ $this->form }}
        </form>

        <x-slot name="footer">
            <x-filament::button type="submit" form-id="password-form">
                {{ __('Update password') }}
            </x-filament::button>
        </x-slot>
    </x-filament::section>
</x-filament-panels::page>
