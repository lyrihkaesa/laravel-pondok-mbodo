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
        // Generate password berdasarkan nama, 4 angka nomor handphone terakhir, dan tanggal lahir
        $password = $data['password'] ?? \App\Utilities\PasswordUtility::generatePassword($data['name'], $data['phone'], $data['birth_date']);
        // dd($password);

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
            'nik' => $data['nik'],
            'gender' => $data['gender'],
            'birth_place' => $data['birth_place'],
            'birth_date' => $data['birth_date'],
            'profile_picture_1x1' => $data['profile_picture_1x1'],
            'province' => $data['province'],
            'regency' => $data['regency'],
            'district' => $data['district'],
            'village' => $data['village'],
            'address' => $data['address'],
            'rt' => $data['rt'],
            'rw' => $data['rw'],
            'postcode' => $data['postcode'],
            'nis' => $data['nis'],
            'nisn' => $data['nisn'],
            'kip' => $data['kip'],
            'current_name_school' => $data['current_name_school'],
            'category' => $data['category'],
            'current_school' => $data['current_school'],
            'status' => $data['status'],
            'birth_certificate' => $data['birth_certificate'],
            'family_card' => $data['family_card'],
            // 'number_family_card' => $data['number_family_card'],
            // 'skhun' => $data['skhun'],
            // 'ijazah' => $data['ijazah'],
            'user_id' => $user->id,
        ]);

        return $record;
    }
}
