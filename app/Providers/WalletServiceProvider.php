<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        \App\Services\WalletService::class => \App\Services\Impl\WalletServiceImpl::class
    ];

    public function provides(): array
    {
        return [
            \App\Services\WalletService::class
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
