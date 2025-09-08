<?php

namespace App\Filament\App\Clusters\Account\Pages;

use App\Filament\App\Clusters\Account\AccountCluster;
use App\Filament\Traits\Notifiable;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class Profile extends Page
{
    use Notifiable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;
    protected static ?string $cluster = AccountCluster::class;
    protected static ?int $navigationSort = 1;
    public ?array $data = [];
    protected string $view = 'filament.app.clusters.account.pages.profile';

    public static function getNavigationLabel(): string
    {
        return __('Profile');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Profile');
    }

    public function mount(): void
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Nombre completo'))
                    ->required()
                    ->string()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('Correo electrónico'))
                    ->required()
                    ->email()
                    ->string()
                    ->unique('users', 'email', ignorable: auth()->user()),
                // ...
            ])
            ->statePath('data');
    }

    public function update(): void
    {
        // save user data
        $user = auth()->user();

        $user->fill($this->form->getState());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->notify(__("Saved"), __("You're profile has been updated successfully."));

        $user->sendEmailVerificationNotification();

        $this->redirect('/auth/verify');
    }
}
