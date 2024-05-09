<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat user untuk peran "Super Admin"
        $adminSuperRole = Role::where('name', 'super_admin')->first();
        $user = User::create([
            'name' => 'Kaesa Lyrih',
            'email' => 'admin@gmail.com',
            'phone' => '628111222333', // Ganti dengan nomor telepon yang diinginkan
            'password' => Hash::make('password'), // password
        ]);

        $user->wallets()->create([
            'id' => $user->phone,
            'name' => 'Dompet Utama',
            'balance' => 0,
        ]);

        Employee::create([
            'user_id' => $user->id,
            'name' => 'Kaesa Lyrih',
            'nik' => '3315040202020002',
            'address' => 'Dusun Sendangsari, Desa Tambirejo, Kec. Toroh, Kab. Grobogan',
            'gender' => 'Laki-Laki',
            'birth_date' => '1990-01-01',
        ]);

        $user->assignRole($adminSuperRole);
    }
}
