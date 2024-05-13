<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class EditProfileEmployee extends Page
{
    protected static ?string $navigationIcon = 'icon-school-director';
    protected static string $view = 'filament.pages.edit-profile-employee';
    protected static ?int $navigationSort = -97;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->employee !== null;
    }

    public function getTitle(): string | Htmlable
    {
        return __('Profile Student');
    }

    public static function getNavigationLabel(): string
    {
        return __('Profile Employee');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Informai Pribadi');
    }
}
