<?php

namespace Database\Seeders;

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
        // Membuat user untuk peran "financial administration"
        $financialRole = Role::where('name', 'financial administration')->first();
        $financialAdmin = User::create([
            'name' => 'Financial Admin Name',
            'email' => 'finance@example.com',
            'phone' => '628444444444', // Ganti dengan nomor telepon yang diinginkan
            'password' => Hash::make('password'),
        ]);
        $financialAdmin->assignRole($financialRole);

        // Membuat user untuk peran "admin super"
        $adminSuperRole = Role::where('name', 'admin super')->first();
        $adminSuper = User::create([
            'name' => 'Admin Super Name',
            'email' => 'admin@example.com',
            'phone' => '628333333333', // Ganti dengan nomor telepon yang diinginkan
            'password' => Hash::make('password'),
        ]);
        $adminSuper->assignRole($adminSuperRole);
    }
}
