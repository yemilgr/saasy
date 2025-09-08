<?php

namespace App\Filament\Admin\Resources\Plans\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PricesRelationManager extends RelationManager
{
    protected static string $relationship = 'prices';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->disabledOn('edit')
                    ->required(),
                TextInput::make('stripe_price_id')
                    ->disabledOn('edit')
                    ->label('Stripe Price ID')
                    ->placeholder('price_###'),
                TextInput::make('amount')
                    ->numeric()
                    ->required(),
                Select::make('currency')
                    ->options([
                        'eur' => 'EUR',
                        'usd' => 'USD',
                    ])
                    ->default(config('cashier.currency'))
                    ->required(),
                Select::make('interval')
                    ->options([
                        'month' => 'Month',
                        'year' => 'Year',
                    ]),
                Toggle::make('active')
                    ->inline(false)
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('stripe_price_id')
                    ->label('Stripe Price ID'),
                TextColumn::make('amount')
                    ->money(config('cashier.currency')),
                TextColumn::make('interval')->badge(),
                IconColumn::make('active')->boolean(),
            ])
            ->paginated(false)
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
