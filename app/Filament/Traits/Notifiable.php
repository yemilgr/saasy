<?php

namespace App\Filament\Traits;

use Filament\Notifications\Notification;

trait Notifiable
{
    public function notify(string $title, string $body = '', string $level = 'success'): void
    {
        Notification::make()
            ->title($title)
            ->body($body)
            ->$level()
            ->send();
    }
}
