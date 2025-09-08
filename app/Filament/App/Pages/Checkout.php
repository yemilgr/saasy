<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Checkout extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.app.pages.checkout';

    public static function getNavigationLabel(): string
    {
        return __('Checkout');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Checkout');
    }
}
