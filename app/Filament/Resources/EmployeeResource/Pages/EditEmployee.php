<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

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
        $data['phone_visibility'] = $user->phone_visibility;
        $data['roles'] = $user->roles->pluck('id')->toArray();
        $data['socialMediaLinks'] = $user->socialMediaLinks;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, $data): Model
    {
        $record->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'phone_visibility' => $data['phone_visibility'],
            'password' => $data['password'] ? Hash::make($data['password']) : $record->user->password,
        ]);

        // Menghapus semua peran yang dimiliki oleh user
        $record->user->syncRoles([Role::find($data['roles'])]);

        // Menghilangkan data yang tidak diperlukan
        unset($data['email']);
        unset($data['phone']);
        unset($data['phone_visibility']);
        unset($data['password']);
        unset($data['roles']);
        unset($data['socialMediaLinks']);

        $record->update($data);

        return $record;
    }

    // protected function getRedirectUrl(): string
    // {
    //     return $this->previousUrl ?? $this->getResource()::getUrl('index');
    // }
}
