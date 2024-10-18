<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Generate password
        $password = $data['password'] ?? \App\Utilities\PasswordUtility::generatePassword($data['name'], $data['phone'], $data['birth_date']);

        // Create User
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'phone_visibility' => $data['phone_visibility'],
            'password' => Hash::make($password),
            'profile_picture_1x1' => $data['user_profile_picture_1x1'],
        ]);


        foreach ($data['roles'] as $roleId) {
            $role = Role::find($roleId);
            if ($role) {
                $user->assignRole($role);
            }
        }

        // Menghilangkan data yang tidak diperlukan
        unset($data['email']);
        unset($data['phone']);
        unset($data['password']);
        unset($data['roles']);
        unset($data['phone_visibility']);
        unset($data['user_profile_picture_1x1']);

        $data['user_id'] = $user->id;

        // Create Student
        $record = static::getModel()::create($data);

        return $record;
    }

    // protected function getRedirectUrl(): string
    // {
    //     return $this->previousUrl ?? $this->getResource()::getUrl('index');
    // }
}
