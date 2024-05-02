<?php

namespace App\Services;

interface WalletService
{
    public function transfer(string $fromWalletId, string $toWalletId, float $amount, array $data): bool;

    public function transferSystemToYayasan(float $amount, array $data): bool;

    public function transferYayasanToSystem(float $amount, array $data): bool;
}
