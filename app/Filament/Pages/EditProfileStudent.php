<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class EditProfileStudent extends Page
{
    protected static ?string $navigationIcon = 'icon-student-male';
    protected static string $view = 'filament.pages.edit-profile-student';
    protected static ?int $navigationSort = -98;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('santri');
    }

    public static function getNavigationLabel(): string
    {
        return __('Profile Student');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Informai Pribadi');
    }
}
