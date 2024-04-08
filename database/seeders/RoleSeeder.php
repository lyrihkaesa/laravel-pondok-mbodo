<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Santri']);
        Role::create(['name' => 'Guru']);
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Pengurus']);
        Role::create(['name' => 'Admin Keuangan']);
        Role::create(['name' => 'Admin Tata Usaha']);
    }
}
