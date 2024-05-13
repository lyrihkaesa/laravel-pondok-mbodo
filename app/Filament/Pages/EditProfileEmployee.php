<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class EditProfileEmployee extends Page
{
    protected static ?string $navigationIcon = 'icon-school-director';
    protected static string $view = 'filament.pages.edit-profile-employee';
    protected static ?int $navigationSort = -97;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('pengurus');
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
