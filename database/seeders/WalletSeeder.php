<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallets = [
            [
                'id' => 'SYSTEM',
                'name' => 'Dompet System',
                'balance' => 0,
                'canMinus' => false,
            ],
            [
                'id' => 'YAYASAN',
                'name' => 'Dompet Yayasan',
                'balance' => 0,
            ],
            [
                'id' => 'DONATUR',
                'name' => 'Dompet Donatur',
                'balance' => 0,
            ],
            [
                'id' => 'DANA_BOS',
                'name' => 'Dompet Dana BOS',
                'balance' => 0,
            ],
            [
                'id' => 'DANA_BOS',
                'name' => 'Dompet Dana BOS',
                'balance' => 0,
            ],
            [
                'id' => '62811122233301',
                'name' => 'Dompet Utama',
                'balance' => 0,
            ],
            [
                'id' => '62811122233302',
                'name' => 'Dompet Utama',
                'balance' => 0,
            ],
        ];

        Wallet::insert($wallets);
    }
}
