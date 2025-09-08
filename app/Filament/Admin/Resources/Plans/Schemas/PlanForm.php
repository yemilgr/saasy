<?php

namespace App\Filament\Admin\Resources\Plans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->disabledOn('edit')
                    ->unique()
                    ->required(),
                TextInput::make('stripe_product_id')
                    ->disabledOn('edit')
                    ->label('Stripe Product ID')
                    ->placeholder('prod_###'),
                Select::make('role_id')
                    ->relationship('role', 'name')
                    ->preload()
                    ->searchable(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('active')
                    ->default(true),
                Toggle::make('default'),
                TagsInput::make('features')
                    ->placeholder('Enter a feature and press enter')
                    ->reorderable()
                    ->columnSpanFull(),
            ]);
    }
}
