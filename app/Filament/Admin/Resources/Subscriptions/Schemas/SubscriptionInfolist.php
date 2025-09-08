<?php

namespace App\Filament\Admin\Resources\Subscriptions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SubscriptionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('plan.name')
                    ->label('Product Plan'),
                TextEntry::make('stripe_id'),
                TextEntry::make('stripe_status'),
                TextEntry::make('stripe_price'),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('trial_ends_at')
                    ->dateTime(),
                TextEntry::make('ends_at')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
