<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum OrganizationCategory: string implements HasLabel, HasColor
{
    case SEKOLAH_FORMAL = 'Sekolah Formal';
    case SEKOLAH_MADRASAH = 'Sekolah Madrasah';
    case PROGRAM_JURUSAN = 'Program Jurusan';
    case BADAN_LEMBAGA = 'Badan Lembaga';
    case PONDOK_PESANTREN = 'Pondok Pesantren';
    case YAYASAN = 'Yayasan';

    public function getLabel(): string
    {
        return match ($this) {
            self::SEKOLAH_FORMAL => __('Sekolah Formal'),
            self::SEKOLAH_MADRASAH => __('Sekolah Madrasah'),
            self::PROGRAM_JURUSAN => __('Program Jurusan'),
            self::BADAN_LEMBAGA => __('Badan Lembaga'),
            self::PONDOK_PESANTREN => __('Pondok Pesantren'),
            self::YAYASAN => __('Yayasan'),
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::SEKOLAH_FORMAL => 'info',
            self::SEKOLAH_MADRASAH => 'success',
            self::PROGRAM_JURUSAN => 'warning',
            self::BADAN_LEMBAGA => 'gray',
            self::PONDOK_PESANTREN => 'danger',
            self::YAYASAN => 'pink',
        };
    }
}
