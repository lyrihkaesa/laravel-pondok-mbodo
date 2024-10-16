<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\StudentResource;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('goToViewEmployeeAction')
                ->label(__('Employee'))
                ->icon('icon-school-director')
                ->visible(fn(Model $record) => $record->user->employee !== null)
                ->url(fn(Model $record) => route('filament.app.resources.employees.view', $record->user->employee))
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
        $data['user_profile_picture_1x1'] = $user->profile_picture_1x1;


        return $data;
    }
}
