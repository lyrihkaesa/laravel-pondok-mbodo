<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;

enum PaymentTerm: string implements HasLabel, HasColor, HasIcon
{
    case ONCE = 'once';
    case MONTHLY = 'monthly';
    case SEMESTER = 'semester';
    case YEARLY = 'yearly';

    public function getLabel(): string
    {
        return match ($this) {
            self::ONCE => __('Once'),
            self::MONTHLY => __('Monthly'),
            self::SEMESTER => __('Semester'),
            self::YEARLY => __('Yearly'),
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ONCE => 'success',
            self::MONTHLY => 'warning',
            self::SEMESTER => 'info',
            self::YEARLY => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ONCE => 'heroicon-o-clock',
            self::MONTHLY => 'heroicon-o-clock',
            self::SEMESTER => 'heroicon-o-clock',
            self::YEARLY => 'heroicon-o-clock',
        };
    }
}
