<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;

enum StudentStatus: string implements HasLabel, HasColor, HasIcon
{
    case ENROLLED = 'Mendaftar';
    case ACTIVE = 'Aktif';
    case GRADUATED = 'Lulus';
    case INACTIVE = 'Tidak Aktif';

    public function getLabel(): string
    {
        return match ($this) {
            self::ENROLLED => __('Enrolled'),
            self::ACTIVE => __('Active'),
            self::GRADUATED => __('Graduated'),
            self::INACTIVE => __('Inactive'),
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ENROLLED => 'pink',
            self::ACTIVE => 'success',
            self::GRADUATED => 'info',
            self::INACTIVE => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ENROLLED => 'heroicon-o-user',
            self::ACTIVE => 'heroicon-o-user',
            self::GRADUATED => 'heroicon-o-user',
            self::INACTIVE => 'heroicon-o-user',
        };
    }
}
