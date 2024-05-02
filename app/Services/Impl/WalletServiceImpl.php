<?php

namespace App\Services\Impl;

use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;

class WalletServiceImpl implements WalletService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function transfer(string $fromWalletId, string $toWalletId, float $amount, array $data = []): bool
    {
        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Kurangi saldo dari dompet sumber
            $fromWallet = Wallet::findOrFail($fromWalletId);
            if ($fromWallet->balance < $amount && $fromWallet->id !== "SYSTEM") {
                throw new \Exception(__('The balance is not enough'));
            }
            $fromWallet->balance -= $amount;
            $fromWallet->save();

            // Tambahkan saldo ke dompet tujuan
            $toWallet = Wallet::findOrFail($toWalletId);
            $toWallet->balance += $amount;
            $toWallet->save();

            $toWallet->destinationTransactions()->create([
                'student_product_id' => $data['student_product_id'] ?? null,
                'name' => $data['name'] ?? 'Transfer Saldo',
                'type' => $data['type'] ?? 'transfer',
                'amount' => $amount,
                'from_wallet_id' => $fromWallet->id,
                'description' => $data['description'] ?? "Transfer saldo " . $amount . " dari " . $fromWallet->id . " ke " . $toWallet->id,
            ]);

            // Commit transaksi database
            DB::commit();
            return true; // Transfer berhasil
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();
            return false; // Transfer gagal
        }
    }

    public function transferSystemToYayasan(float $amount, array $data): bool
    {
        return $this->transfer('SYSTEM', 'YAYASAN', $amount, $data);
    }

    public function transferYayasanToSystem(float $amount, array $data): bool
    {
        return $this->transfer('YAYASAN', 'SYSTEM', $amount, $data);
    }
}
