<?php

namespace App\Services;

use App\Models\FinancialTransaction;

interface WalletService
{
    public function transfer(int $fromWalletId, int $toWalletId, float $amount, FinancialTransaction $financialTransaction): array;

    public function transferSystemToYayasan(float $amount, FinancialTransaction $financialTransaction): array;

    public function transferYayasanToSystem(float $amount, FinancialTransaction $financialTransaction): array;
}
