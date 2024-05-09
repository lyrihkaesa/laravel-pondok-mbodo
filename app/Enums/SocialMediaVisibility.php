<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasDescription;

enum SocialMediaVisibility: string implements HasLabel, HasColor, HasIcon, HasDescription
{
    case PUBLIC = 'public';
    case PRIVATE = 'private';
    case MEMBER = 'member';

    public function getLabel(): string
    {
        return match ($this) {
            self::PUBLIC => __('Public'),
            self::PRIVATE => __('Private'),
            self::MEMBER => __('Member'),
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PUBLIC => 'info',
            self::PRIVATE => 'success',
            self::MEMBER => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PUBLIC => 'heroicon-o-globe-alt',
            self::PRIVATE => 'heroicon-o-lock-closed',
            self::MEMBER => 'heroicon-o-users',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::PUBLIC => __('Public Description'),
            self::PRIVATE => __('Private Description'),
            self::MEMBER => __('Member Description'),
        };
    }
}
