<?php

namespace App\Filament\Pages;

use Exception;
use Filament\Pages\Page;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Auth\Authenticatable;

class EditProfileStudent extends Page
{
    protected static ?string $navigationIcon = 'icon-student-male';
    protected static string $view = 'filament.pages.edit-profile-student';
    protected static ?int $navigationSort = -98;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->student !== null;
    }

    public function getTitle(): string | Htmlable
    {
        return __('Profile Student');
    }

    public static function getNavigationLabel(): string
    {
        return __('Profile Student');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Informai Pribadi');
    }

    protected function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        if (!$user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }
        return $user;
    }
}
