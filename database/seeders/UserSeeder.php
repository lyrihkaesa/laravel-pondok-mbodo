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
        $adminSuperRole = Role::where('name', 'Super Admin')->first();
        $adminSuper = User::create([
            'name' => 'Kaesa Lyrih',
            'email' => 'admin@gmail.com',
            'phone' => '628111222333', // Ganti dengan nomor telepon yang diinginkan
            'password' => Hash::make('password'), // password
        ]);

        Employee::create([
            'user_id' => $adminSuper->id,
            'name' => 'Kaesa Lyrih',
            'email' => 'admin@gmail.com',
            'phone' => '628111222333',
            'address' => 'Dusun Sendangsari, Desa Tambirejo, Kec. Toroh, Kab. Grobogan',
            'gender' => 'MALE',
            'birth_date' => '1990-01-01',
        ]);

        $adminSuper->assignRole($adminSuperRole);
    }
}
