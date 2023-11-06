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
        Role::create(['name' => 'student']);
        Role::create(['name' => 'teacher']);
        Role::create(['name' => 'financial administration']);
        $adminSuper = Role::create(['name' => 'admin super']);

        // Mengaitkan semua izin ke peran "admin super"
        $adminSuper->givePermissionTo('manage users');
        $adminSuper->givePermissionTo('manage roles');
        $adminSuper->givePermissionTo('manage permissions');
    }
}
