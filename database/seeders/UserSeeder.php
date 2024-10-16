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
        // Gunakan Hash::make() jika mendapatkan error berikut:
        // RuntimeException Could not verify the hashed value's configuration.
        $password = Hash::make('password');
        // $password = '$2y$10$LRwNfyUnjpOgX2o0vbvLiuM1oVTo9yx.MbHKoHWeazIc8bLEw9hNq';

        // Role
        $roleAdminSuper = Role::where('name', 'super_admin')->first();
        $rolePengurus = Role::where('name', 'pengurus')->first();

        $userKaesa = User::create([
            'name' => 'Kaesa Lyrih',
            'email' => 'admin@gmail.com',
            'phone' => '628111222333', // Ganti dengan nomor telepon yang diinginkan
            'phone_visibility' => 'private',
            'password' => $password, // password
        ]);

        $userKaesa->wallets()->create([
            'wallet_code' => $userKaesa->phone,
            'name' => 'Dompet Utama',
            'balance' => 0,
        ]);

        Employee::create([
            'user_id' => $userKaesa->id,
            'name' => $userKaesa->name,
            'nik' => '3315040202020002',
            'address' => 'Dusun Sendangsari, Desa Tambirejo, Kec. Toroh, Kab. Grobogan',
            'gender' => 'Laki-Laki',
            'birth_date' => '1990-01-01',
        ]);

        $userKaesa->assignRole($roleAdminSuper);
        $userKaesa->assignRole($rolePengurus);

        // Membuat Pengurus 01 Wajib
        $userPengurus01 = User::create([
            'name' => 'Abah K.H. Muhammad Ghufron Mulyadi',
            'email' => 'abah@gmail.com',
            'phone' => '628999888777', // Ganti dengan nomor telepon yang diinginkan
            'phone_visibility' => 'private',
            'password' => $password, // password
        ]);

        $userPengurus01->wallets()->create([
            'wallet_code' => $userPengurus01->phone,
            'name' => 'Dompet Utama',
            'balance' => 0,
        ]);

        Employee::create([
            'user_id' => $userPengurus01->id,
            'name' => $userPengurus01->name,
            'nik' => '3315040202820002',
            'address' => 'Dusun Sendangsari, Desa Tambirejo, Kec. Toroh, Kab. Grobogan',
            'gender' => 'Laki-Laki',
            'birth_date' => '1990-01-01',
        ]);

        $userPengurus01->assignRole($rolePengurus);

        $userPengurus02 = User::create([
            'name' => 'Yani Example Name',
            'email' => 'yani@gmail.com',
            'phone' => '6282224255517', // Ganti dengan nomor telepon yang diinginkan
            'phone_visibility' => 'public',
            'password' => $password, // password
        ]);

        $userPengurus02->wallets()->create([
            'wallet_code' => $userPengurus02->phone,
            'name' => 'Dompet Utama',
            'balance' => 0,
        ]);

        Employee::create([
            'user_id' => $userPengurus02->id,
            'name' => $userPengurus02->name,
            'nik' => '3315040203020002',
            'address' => 'Dusun Sendangsari, Desa Tambirejo, Kec. Toroh, Kab. Grobogan',
            'gender' => 'Perempuan',
            'birth_date' => '1990-01-01',
        ]);

        $userPengurus02->assignRole($rolePengurus);


        // Membuat Pengurus 02 Wajib
        $userPengurus03 = User::create([
            'name' => 'Fera Example Name',
            'email' => 'fera@gmail.com',
            'phone' => '6282137079827', // Ganti dengan nomor telepon yang diinginkan
            'phone_visibility' => 'public',
            'password' => $password, // password
        ]);

        $userPengurus03->wallets()->create([
            'wallet_code' => $userPengurus03->phone,
            'name' => 'Dompet Utama',
            'balance' => 0,
        ]);

        Employee::create([
            'user_id' => $userPengurus03->id,
            'name' => $userPengurus03->name,
            'nik' => '3315046202020002',
            'address' => 'Dusun Sendangsari, Desa Tambirejo, Kec. Toroh, Kab. Grobogan',
            'gender' => 'Perempuan',
            'birth_date' => '1990-01-01',
        ]);

        $userPengurus03->assignRole($rolePengurus);


        // Membuat Pengurus 03 Wajib
        $userPengurus04 = User::create([
            'name' => 'Toriq Example Name',
            'email' => 'toriq@gmail.com',
            'phone' => '6285803036153', // Ganti dengan nomor telepon yang diinginkan
            'phone_visibility' => 'public',
            'password' => $password, // password
        ]);

        $userPengurus04->wallets()->create([
            'wallet_code' => $userPengurus04->phone,
            'name' => 'Dompet Utama',
            'balance' => 0,
        ]);

        Employee::create([
            'user_id' => $userPengurus04->id,
            'name' => $userPengurus04->name,
            'nik' => '3315040202920002',
            'address' => 'Dusun Sendangsari, Desa Tambirejo, Kec. Toroh, Kab. Grobogan',
            'gender' => 'Laki-Laki',
            'birth_date' => '1990-01-01',
        ]);

        $userPengurus04->assignRole($rolePengurus);
    }
}
