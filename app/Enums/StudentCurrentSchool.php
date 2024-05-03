<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StudentCurrentSchool: string implements HasLabel, HasColor
{
    case PAUDTK = 'PAUD/TK';
    case MI = 'MI';
    case SMP = 'SMP';
    case MA = 'MA';
    case TAKHASUS = 'Takhasus';

    public function getLabel(): string
    {
        return match ($this) {
            self::PAUDTK => __('PAUD/TK'),
            self::MI => __('MI'),
            self::SMP => __('SMP'),
            self::MA => __('MA'),
            self::TAKHASUS => __('Takhasus'),
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PAUDTK => 'pink',
            self::MI => 'danger',
            self::SMP => 'warning',
            self::MA => 'success',
            self::TAKHASUS => 'info',
        };
    }
}
