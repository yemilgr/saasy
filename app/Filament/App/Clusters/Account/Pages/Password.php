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
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use JetBrains\PhpStorm\NoReturn;

class Password extends Page
{
    use Notifiable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;
    protected static ?int $navigationSort = 2;
    protected static ?string $cluster = AccountCluster::class;
    public ?array $data = [];
    protected string $view = 'filament.app.clusters.account.pages.password';

    public static function getNavigationLabel(): string
    {
        return __('Security');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Security');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('current_password')
                    ->label(__('Current password'))
                    ->password()
                    ->autocomplete('current-password')
                    ->required()
                    ->currentPassword(),

                TextInput::make('password')
                    ->label(__('New password'))
                    ->password()
                    ->autocomplete('new-password')
                    ->required()
                    ->rules([PasswordRule::defaults()])
                    ->confirmed(),

                TextInput::make('password_confirmation')
                    ->label(__('Confirm new password'))
                    ->password()
                    ->autocomplete('new-password')
                    ->required(),
            ])
            ->statePath('data');
    }

    #[NoReturn]
    public function update(): void
    {
        auth()->user()->update([
            'password' => Hash::make($this->form->getState()['password']),
        ]);

        $this->form->fill();

        $this->notify(__('Saved'), __('Password updated successfully.'));
    }
}
