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
        // Generate password berdasarkan nama, 4 angka nomor handphone terakhir, dan tanggal lahir
        $password = $data['password'] ?? \App\Utilities\PasswordUtility::generatePassword($data['name'], $data['phone'], $data['birth_date']);
        dd($password);

        // Create User
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($password),
        ]);

        // Assign 'Student' Role
        $role = Role::where('name', 'Santri')->first();
        $user->assignRole($role);

        // Create Student
        $record = static::getModel()::create([
            'name' => $data['name'],
            'nis' => $data['nis'],
            'gender' => $data['gender'],
            'birth_date' => $data['birth_date'],
            'province' => $data['province'],
            'regency' => $data['regency'],
            'district' => $data['district'],
            'village' => $data['village'],
            'postcode' => $data['postcode'],
            'user_id' => $user->id,
        ]);

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
