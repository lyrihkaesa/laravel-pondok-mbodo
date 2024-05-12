<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class EditProfileEmployee extends Page
{
    protected static ?string $navigationIcon = 'icon-school-director';

    protected static string $view = 'filament.pages.edit-profile-employee';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('pengurus');
    }

    public static function getNavigationLabel(): string
    {
        return __('Profile Employee');
    }
}
