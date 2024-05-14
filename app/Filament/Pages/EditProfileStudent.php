<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms\Concerns\InteractsWithForms;

class EditProfileStudent extends Page
{
    protected static ?string $navigationIcon = 'icon-student-male';
    protected static ?string $slug = 'my/santri';
    protected static string $view = 'filament.pages.edit-profile-student';

    // Custom property
    public ?array $profileData = [];

    // public static function shouldRegisterNavigation(): bool
    // {
    //     return auth()->user()->student !== null;
    // }

    public static function canAccess(): bool
    {
        return auth()->user()->student !== null;
    }

    public function getTitle(): string | Htmlable
    {
        return __('Profile Student');
    }

    public static function getNavigationLabel(): string
    {
        return __('Profile Student');
    }

    public static function getNavigationSort(): ?int
    {
        return \App\Utilities\FilamentUtility::getNavigationSort(__('Profile Student'));
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Informai Pribadi');
    }

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'editStudentForm',
        ];
    }

    public function editStudentForm(Form $form): Form
    {
        return $form
            ->schema([
                //
            ])
            ->model($this->getStudent())
            ->statePath('profileData');
    }

    protected function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        if (!$user instanceof Model) {
            throw new \Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }
        return $user;
    }

    protected function getStudent(): Model
    {
        return $this->getUser()->student ?? abort(404);
    }

    protected function fillForms(): void
    {
        $user = $this->getUser();
        $studentModelArr = $this->getStudent()->attributesToArray();
        $studentModelArr['roles'] = $user->roles->pluck('id')->toArray();
        $studentModelArr['name'] = $user->name;
        // dd($studentModelArr);
        $this->editStudentForm->fill($studentModelArr);
    }

    protected function getUpdateStudentFormActions(): array
    {
        return [
            Action::make('updateStudentAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editStudentForm'),
        ];
    }

    public function updateStudent(): void
    {
        $data = $this->editStudentForm->getState();
        $this->handleRecordUpdate($this->getStudent(), $data);
    }

    private function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            DB::beginTransaction();

            $record->update($data);

            DB::commit();

            Notification::make()
                ->success()
                ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
                ->send();

            return $record;
        } catch (\Exception $exception) {
            DB::rollBack();

            Notification::make()
                ->title(__('Failed'))
                ->danger()
                ->send();
            return $record;
        }
    }
}
