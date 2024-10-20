<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Calendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.pages.calendar';

    public static function canAccess(): bool
    {
        return auth('web')->user()->can('page_Calendar');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Calendar Page');
    }

    public static function getNavigationLabel(): string
    {
        return __('Calendar Page');
    }

    public static function getNavigationSort(): ?int
    {
        return \App\Utilities\FilamentUtility::getNavigationSort(__('Calendar Page'));
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Calendar');
    }
}
