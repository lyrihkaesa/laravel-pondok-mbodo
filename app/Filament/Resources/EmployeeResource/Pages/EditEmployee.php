<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Exception;
use Filament\Actions;
use App\Enums\StudentStatus;
use App\Enums\StudentCategory;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Enums\StudentCurrentSchool;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EmployeeResource;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\Action::make('convertToStudentAction')
                ->label(__('Convert to Student'))
                ->requiresConfirmation()
                ->icon('icon-student-male')
                ->color('warning')
                ->visible(fn (Model $record) => $record->user->student === null)
                ->action(function (Model $record) {

                    $userModel = $record->user;

                    try {
                        DB::beginTransaction();

                        $dataEmployeeModel = $record->toArray();

                        // Umum menghilangkan data yang tidak ada di table students
                        unset($dataEmployeeModel['id']);
                        unset($dataEmployeeModel['user']);
                        unset($dataEmployeeModel['created_at']);
                        unset($dataEmployeeModel['updated_at']);
                        unset($dataEmployeeModel['deleted_at']);

                        // Spesifik menghilangkan data yang tidak ada di table students
                        unset($dataEmployeeModel['niy']);
                        unset($dataEmployeeModel['salary']);
                        unset($dataEmployeeModel['start_employment_date']);

                        // Menambahkan default nilai pada column di table students
                        $dataEmployeeModel['status'] = StudentStatus::ACTIVE;
                        $dataEmployeeModel['current_school'] = StudentCurrentSchool::MA;
                        $dataEmployeeModel['category'] = StudentCategory::REGULER;

                        $studentModel = $userModel->student()->create($dataEmployeeModel);

                        $role = Role::where('name', 'santri')->first();
                        $userModel->assignRole($role);

                        DB::commit();

                        redirect(route('filament.admin.resources.students.edit', $studentModel));

                        Notification::make()
                            ->title(__('Success'))
                            ->body(__('Convertion data Employee to Student', [
                                'name' => $userModel->name,
                            ]))
                            ->success()
                            ->send();
                    } catch (Exception $exception) {
                        DB::rollBack();

                        Notification::make()
                            ->title(__('Failed'))
                            ->body(__('Convertion data Employee to Student', [
                                'name' => $userModel->name,
                            ]))
                            ->danger()
                            ->send();
                    }
                }),
            Actions\Action::make('goToStudentAction')
                ->label(__('Student'))
                ->icon('icon-student-male')
                ->visible(fn (Model $record) => $record->user->student !== null)
                ->url(fn (Model $record) => route('filament.admin.resources.students.edit', $record->user->student))
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
        $data['roles'] = $user->roles->pluck('id')->toArray();
        $data['socialMediaLinks'] = $user->socialMediaLinks;
        $data['user_profile_picture_1x1'] = $user->profile_picture_1x1;

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
            'profile_picture_1x1' => $data['user_profile_picture_1x1'],
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
        unset($data['user_profile_picture_1x1']);

        $record->update($data);

        return $record;
    }

    // protected function getRedirectUrl(): string
    // {
    //     return $this->previousUrl ?? $this->getResource()::getUrl('index');
    // }
}
