<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // dd($data);
        // Generate password
        $password = $data['password'] ?? \App\Utilities\PasswordUtility::generatePassword($data['name'], $data['phone'], $data['birth_date']);
        // dd($password);

        // Create User
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'phone_visibility' => $data['phone_visibility'],
            'password' => Hash::make($password),
        ]);

        // Assign 'Student' Role
        $role = Role::where('name', 'santri')->first();
        $user->assignRole($role);

        // Create Student
        // Menghilangkan data yang tidak diperlukan
        unset($data['email']);
        unset($data['phone']);
        unset($data['password']);
        unset($data['phone_visibility']);

        $data['user_id'] = $user->id;

        $record = static::getModel()::create($data);

        return $record;
    }
}
