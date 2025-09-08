<?php

namespace App\Models\Traits;

use App\Models\Role;
use Filament\Panel;

trait Filamentable
{
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->hasRole(Role::Admin),
            'app' => $this->hasVerifiedEmail(),
            default => false,
        };
    }

//    public function getFilamentAvatarUrl(): ?string
//    {
//        return $this->avatar_url;
//    }
}
