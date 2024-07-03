<?php

namespace App\Services\Impl;

use App\Models\Wallet;
use Illuminate\Support\Number;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use App\Models\FinancialTransaction;

class WalletServiceImpl implements WalletService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function transfer(int $fromWalletId, int $toWalletId, float $amount, FinancialTransaction $financialTransaction): array
    {
        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Kurangi saldo dari dompet sumber
            $fromWallet = Wallet::findOrFail($fromWalletId);
            $policy = $fromWallet->policy ?? [];
            // dd([$fromWallet->balance < $amount, in_array("ALLOW_NEGATIVE_BALANCE", $policy)]);
            if ($fromWallet->balance < $amount && !in_array("ALLOW_NEGATIVE_BALANCE", $policy)) {
                throw new \Exception(__('The balance is not enough', [
                    'wallet_name' => $fromWallet->name,
                    'wallet_balance' => Number::currency($fromWallet->balance, 'IDR', 'id'),
                    'amount' => Number::currency($amount, 'IDR', 'id')
                ]));
            }
            $fromWallet->balance -= $amount;
            $fromWallet->save();

            // Tambahkan saldo ke dompet tujuan
            $toWallet = Wallet::findOrFail($toWalletId);
            $toWallet->balance += $amount;
            $toWallet->save();

            $financialTransaction->from_wallet_id = $fromWallet->id;
            $financialTransaction->to_wallet_id = $toWallet->id;
            $financialTransaction->amount = $amount;

            $financialTransaction->name = $financialTransaction->name ?? "Transfer Saldo";
            $financialTransaction->type = $financialTransaction->type ?? "transfer";
            $financialTransaction->description = $financialTransaction->description ?? "Transfer saldo " . Number::currency($amount, 'IDR', 'id') . " dari #$fromWallet->wallet_code ke #$toWallet->wallet_code";
            $financialTransaction->validated_by = $financialTransaction->validated_by ?? auth()->user()->id;

            $financialTransaction->save();

            // Commit transaksi database
            DB::commit();
            return [
                'is_success' => true,
                'message' => 'Transfer saldo ' . $amount . ' dari ' . $fromWallet->wallet_code . ' ke ' . $toWallet->wallet_code . ' berhasil',
            ]; // Transfer berhasil
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();
            return [
                'is_success' => false,
                'message' => $e->getMessage(),
            ]; // Transfer gagal
        }
    }

    public function transferSystemToYayasan(float $amount, FinancialTransaction $financialTransaction): array
    {
        $financialTransaction->transaction_at = now();
        $idWalletSystem = Wallet::system()->first()->id;
        $idWalletYayasan = Wallet::yayasan()->first()->id;
        return $this->transfer($idWalletSystem, $idWalletYayasan, $amount, $financialTransaction);
    }

    public function transferYayasanToSystem(float $amount, FinancialTransaction $financialTransaction): array
    {
        $financialTransaction->transaction_at = now();
        $idWalletSystem = Wallet::system()->first()->id;
        $idWalletYayasan = Wallet::yayasan()->first()->id;
        return $this->transfer($idWalletYayasan,  $idWalletSystem, $amount, $financialTransaction);
    }
}
