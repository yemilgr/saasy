<?php

namespace App\Providers\Filament;

use App\Filament\App\Clusters\Account\Pages\Billing;
use App\Filament\App\Clusters\Account\Pages\Profile;
use App\Models\Role;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('app')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->font('Montserrat')
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\Filament\App\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\Filament\App\Pages')
            ->discoverClusters(in: app_path('Filament/App/Clusters'), for: 'App\Filament\App\Clusters')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\Filament\App\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->viteTheme('resources/css/filament/app/theme.css')
            ->topNavigation()
            ->userMenuItems($this->getUserMenuItems())
            ->navigationItems($this->getNavigationItems())
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->spa(hasPrefetching: true)
            ->unsavedChangesAlerts()
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    private function getUserMenuItems(): array
    {
        return [
            Action::make('profile')
                ->label(__('Profile'))
                ->url(fn () => Profile::getUrl())
                ->icon(Heroicon::OutlinedUser),

            Action::make('billing')
                ->label(__('Billing'))
                ->url(fn () => Billing::getUrl())
                ->icon(Heroicon::OutlinedCreditCard),

            Action::make('admin')
                ->label('Admin')
                ->url(fn (): string => route('filament.admin.pages.dashboard'))
                ->visible(fn () => auth()->user()?->hasRole(Role::Admin))
                ->icon(Heroicon::OutlinedShieldCheck),

        ];
    }

    private function getNavigationItems(): array
    {
        return [
            //
        ];
    }
}
