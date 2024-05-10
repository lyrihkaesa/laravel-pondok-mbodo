<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasDescription;

enum SocialMediaPlatform: string implements HasLabel, HasColor, HasIcon, HasDescription
{
    case WEB = 'web';
    case INSTAGRAM = 'instagram';
    case FACEBOOK = 'facebook';
        // case WHATSAPP = 'whatsapp';
    case TWITTER = 'twitter';
    case YOUTUBE = 'youtube';

    public function getLabel(): string
    {
        return match ($this) {
            self::WEB => __('Web'),
            self::INSTAGRAM => __('Instagram'),
            self::FACEBOOK => __('Facebook'),
            // self::WHATSAPP => __('Whatsapp'),
            self::TWITTER => __('Twitter'),
            self::YOUTUBE => __('Youtube'),
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::WEB => 'grey',
            self::INSTAGRAM => 'pink',
            self::FACEBOOK => 'info',
            // self::WHATSAPP => 'success',
            self::TWITTER => 'info',
            self::YOUTUBE => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::WEB => 'heroicon-o-globe-alt',
            self::INSTAGRAM => 'icon-instagram',
            self::FACEBOOK => 'icon-facebook',
            // self::WHATSAPP => 'icon-whatsapp',
            self::TWITTER => 'heroicon-o-x-mark',
            self::YOUTUBE => 'icon-youtube',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::WEB => __('Web Description'),
            self::INSTAGRAM => __('Instagram Description'),
            self::FACEBOOK => __('Facebook Description'),
            // self::WHATSAPP => __('Whatsapp Description'),
            self::TWITTER => __('Twitter Description'),
            self::YOUTUBE => __('Youtube Description'),
        };
    }

    public function getRedirectUrl(string $username): ?string
    {
        return match ($this) {
            self::WEB => 'https://lyrihkaesa.github.io',
            self::INSTAGRAM => 'https://www.instagram.com/' . $username,
            self::FACEBOOK => 'https://www.facebook.com/' . $username,
            // self::WHATSAPP => 'https://wa.me/' . $username,
            self::TWITTER => 'https://twitter.com/' . $username,
            self::YOUTUBE => 'https://youtube.com/@' . $username,
        };
    }
}
