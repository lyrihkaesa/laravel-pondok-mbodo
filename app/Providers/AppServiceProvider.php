<?php

namespace App\Providers;

use Illuminate\Support\Number;
use Filament\Support\Colors\Color;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            // 'primary' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
            'primary' => Color::Lime,
            'pink' => Color::Pink,
            'neutral' => Color::Neutral,
        ]);

        Number::useLocale('id');
    }
}
