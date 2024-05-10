<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class SocialMediaLinkServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        \App\Services\SocialMediaLinkService::class => \App\Services\Impl\SocialMediaLinkServiceImpl::class
    ];

    public function provides(): array
    {
        return [
            \App\Services\SocialMediaLinkService::class
        ];
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
