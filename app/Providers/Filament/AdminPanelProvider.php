<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use App\Filament\Pages\EditProfile;
use App\Filament\Pages\EditProfileStudent;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Pages\EditProfileEmployee;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->sidebarCollapsibleOnDesktop()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(__('Profile'))
                    ->icon('heroicon-o-user-circle')
                    ->url(fn (): string => EditProfile::getUrl()),
                'home' => MenuItem::make()
                    ->label(__('Home'))
                    ->icon('heroicon-o-home')
                    ->url(fn (): string => '/'),
                'profile student' => MenuItem::make()
                    ->label(__('Profile Student'))
                    ->icon('icon-student-male')
                    ->visible(fn (): bool => auth()->user()->student !== null)
                    ->url(fn (): string => EditProfileStudent::getUrl()),
                'profile employee' => MenuItem::make()
                    ->label(__('Profile Employee'))
                    ->icon('icon-school-director')
                    ->visible(fn (): bool => auth()->user()->employee !== null)
                    ->url(fn (): string => EditProfileEmployee::getUrl()),
            ])
            ->colors([
                // 'primary' => Color::Lime,
                // 'pink' => Color::Pink,
                // 'neutral' => Color::Neutral,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                \Saade\FilamentFullCalendar\FilamentFullCalendarPlugin::make()
                    ->selectable()
                    ->editable(),
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->databaseNotifications();
    }
}
