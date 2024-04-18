<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = $this->getRecord()->user;

        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['phone'] = $user->phone;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, $data): Model
    {
        // dd([$data, $record]);
        $record->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'] ? Hash::make($data['password']) : $record->user->password,
        ]);

        $record->update([
            'name' => $data['name'],
            'nik' => $data['nik'],
            'nis' => $data['nis'],
            'nisn' => $data['nisn'],
            'profile_picture_1x1' => $data['profile_picture_1x1'],
            'profile_picture_3x4' => $data['profile_picture_3x4'],
            'profile_picture_4x6' => $data['profile_picture_4x6'],
            'gender' => $data['gender'],
            'birth_place' => $data['birth_place'],
            'birth_date' => $data['birth_date'],
            'province' => $data['province'],
            'regency' => $data['regency'],
            'district' => $data['district'],
            'village' => $data['village'],
            'postcode' => $data['postcode'],
            'address' => $data['address'],
            'rt' => $data['rt'],
            'rw' => $data['rw'],
            // 'full_address' => $data['full_address'],
            'status' => $data['status'],
            'current_school' => $data['current_school'],
            'birth_certificate' => $data['birth_certificate'],
            'family_card' => $data['family_card'],
            // 'nip' => $data['nip'],
        ]);

        return $record;
    }
}
