<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;

enum Gender: string implements HasLabel, HasColor, HasIcon
{
    case MALE = 'Laki-Laki';
    case FEMALE = 'Perempuan';

    public function getLabel(): string
    {
        return match ($this) {
            self::MALE => __('Male'),
            self::FEMALE => __('Female'),
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::MALE => 'info',
            self::FEMALE => 'pink',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::MALE => 'icon-male',
            self::FEMALE => 'icon-female',
        };
    }
}
