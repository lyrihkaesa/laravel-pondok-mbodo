<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Exception;
use Filament\Actions;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\StudentResource;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\Action::make('convertToEmployeeAction')
                ->label(__('Convert to Employee'))
                ->requiresConfirmation()
                ->icon('icon-school-director')
                ->color('warning')
                ->visible(fn (Model $record) => $record->user->employee === null)
                ->action(function (Model $record) {

                    $userModel = $record->user;

                    try {
                        DB::beginTransaction();

                        $dataStudentModel = $record->toArray();

                        // Umum menghilangkan data yang tidak ada di table students
                        unset($dataStudentModel['id']);
                        unset($dataStudentModel['user']);
                        unset($dataStudentModel['created_at']);
                        unset($dataStudentModel['updated_at']);
                        unset($dataStudentModel['deleted_at']);

                        // Spesifik menghilangkan data yang tidak ada di table students
                        unset($dataStudentModel['nip']);
                        unset($dataStudentModel['nisn']);
                        unset($dataStudentModel['kip']);
                        unset($dataStudentModel['status']);
                        unset($dataStudentModel['current_school']);
                        unset($dataStudentModel['category']);

                        // Menambahkan default nilai pada column di table students
                        $dataStudentModel['salary']  = 0;
                        $dataStudentModel['start_employment_date']  = now();

                        $employeeModel = $userModel->employee()->create($dataStudentModel);

                        $role = Role::where('name', 'pengurus')->first();
                        $userModel->assignRole($role);

                        DB::commit();

                        redirect(route('filament.admin.resources.employees.edit', $employeeModel));

                        Notification::make()
                            ->title(__('Success'))
                            ->body(__('Convertion data Student to Employee', [
                                'name' => $userModel->name,
                            ]))
                            ->success()
                            ->send();
                    } catch (Exception $exception) {

                        DB::rollBack();

                        Notification::make()
                            ->title(__('Failed'))
                            ->body(__('Convertion data Student to Employee', [
                                'name' => $userModel->name,
                            ]))
                            ->danger()
                            ->send();
                    }
                }),
            Actions\Action::make('goToEmployeeAction')
                ->label(__('Employee'))
                ->icon('icon-school-director')
                ->visible(fn (Model $record) => $record->user->employee !== null)
                ->url(fn (Model $record) => route('filament.admin.resources.employees.edit', $record->user->employee))
                ->openUrlInNewTab(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = $this->getRecord()->user;

        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['phone'] = $user->phone;
        $data['phone_visibility'] = $user->phone_visibility;
        $data['socialMediaLinks'] = $user->socialMediaLinks;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, $data): Model
    {
        // dd([$data, $record]);
        $userModel = $record->user;
        $userModel->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'phone_visibility' => $data['phone_visibility'],
            'password' => $data['password'] ? Hash::make($data['password']) : $record->user->password,
        ]);

        // Menghilangkan data yang tidak diperlukan
        unset($data['email']);
        unset($data['phone']);
        unset($data['phone_visibility']);
        unset($data['password']);
        unset($data['socialMediaLinks']);

        $record->update($data);

        return $record;
    }
}
