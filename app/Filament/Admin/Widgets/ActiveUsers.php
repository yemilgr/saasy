<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Role;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class ActiveUsers extends StatsOverviewWidget
{
    protected ?string $heading = 'Analytics';

    protected ?string $description = 'An users subscription overview.';

    protected function getStats(): array
    {
        return [
            Stat::make('Active Users', $this->getActiveUsers())
                ->icon('heroicon-m-users'),
            Stat::make('Active Subscriptions', $this->getActiveSubscriptions())
                ->icon('heroicon-m-currency-dollar'),
        ];
    }

    private function getActiveUsers()
    {
        return User::query()->withoutRole(Role::Admin)->count();
    }

    private function getActiveSubscriptions(): int
    {
        return User::query()->whereHas('subscriptions', fn (Builder $builder) => $builder->active())->count();
    }
}
