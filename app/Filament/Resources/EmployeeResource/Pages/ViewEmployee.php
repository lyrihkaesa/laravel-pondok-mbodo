<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\EmployeeResource;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('goToViewStudentAction')
                ->label(__('Student'))
                ->icon('icon-student-male')
                ->visible(fn (Model $record) => $record->user->student !== null)
                ->url(fn (Model $record) => route('filament.admin.resources.students.view', $record->user->student))
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
}
