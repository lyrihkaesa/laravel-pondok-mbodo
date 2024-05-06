<?php

namespace App\Services;

use App\Models\FinancialTransaction;

interface WalletService
{
    public function transfer(string $fromWalletId, string $toWalletId, float $amount, FinancialTransaction $financialTransaction): array;

    public function transferSystemToYayasan(float $amount, FinancialTransaction $financialTransaction): array;

    public function transferYayasanToSystem(float $amount, FinancialTransaction $financialTransaction): array;
}
