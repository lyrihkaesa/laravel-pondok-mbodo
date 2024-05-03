<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;

enum StudentCategory: string implements HasLabel, HasColor, HasIcon
{
    case REGULER = 'Santri Reguler';
    case NDALEM = 'Santri Ndalem';
    case BERPRESTASI = 'Santri Berprestasi';

    public function getLabel(): string
    {
        return match ($this) {
            self::REGULER => __('Santri Reguler'),
            self::NDALEM => __('Santri Ndalem'),
            self::BERPRESTASI => __('Santri Berprestasi'),
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::REGULER => 'info',
            self::NDALEM => 'warning',
            self::BERPRESTASI => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::REGULER => 'heroicon-o-user',
            self::NDALEM => 'heroicon-o-user',
            self::BERPRESTASI => 'heroicon-o-user',
        };
    }
}
