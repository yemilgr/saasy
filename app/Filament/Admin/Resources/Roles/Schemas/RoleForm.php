<?php

namespace App\Filament\Admin\Resources\Roles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->unique()
                    ->required(),
                TextInput::make('guard_name')
                    ->default(config('auth.defaults.guard'))
                    ->required(),
            ]);
    }
}
