<?php

namespace App\Filament\Pages;

use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use App\Enums\SocialMediaVisibility;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms\Concerns\InteractsWithForms;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $slug = 'my';
    protected static string $view = 'filament.pages.edit-profile';
    protected static ?int $navigationSort = -99;

    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function getTitle(): string | Htmlable
    {
        return __('Profile');
    }

    public static function getNavigationLabel(): string
    {
        return __('Profile');
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
            'editProfileForm',
            'editPasswordForm',
        ];
    }
    public function editProfileForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Profile Information'))
                    ->description(__('Update your accounts profile information and email address.'))
                    ->aside()
                    ->schema([
                        Forms\Components\FileUpload::make('profile_picture_1x1')
                            ->label(__('Profile Picture 1x1'))
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText())
                            ->image()
                            ->downloadable()
                            ->openable()
                            ->directory('profile_pictures'),
                        Forms\Components\TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label(__('Email'))
                            ->unique(ignoreRecord: true)
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('Phone'))
                            ->placeholder(__('Phone Placeholder'))
                            ->helperText(__('Phone Helper Text'))
                            ->unique(ignoreRecord: true)
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\ToggleButtons::make('phone_visibility')
                            ->label(__('Phone Visibility'))
                            ->debounce(delay: 200)
                            ->inline()
                            ->options(SocialMediaVisibility::class)
                            ->default(SocialMediaVisibility::PUBLIC)
                            ->helperText(fn ($state) => str((($state instanceof SocialMediaVisibility) ? $state : SocialMediaVisibility::from($state))->getDescription())->markdown()->toHtmlString())
                            ->required(),
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('profileData');
    }

    public function editPasswordForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Update Password'))
                    ->description(__('Ensure your account is using long, random password to stay secure.'))
                    ->aside()
                    ->schema([
                        Forms\Components\TextInput::make('Current password')
                            ->label(__('Current Password'))
                            ->password()
                            ->revealable()
                            ->required()
                            ->currentPassword(),
                        Forms\Components\TextInput::make('password')
                            ->label(__('New Password'))
                            ->password()
                            ->revealable()
                            ->required()
                            ->rule(Password::default())
                            ->autocomplete('new-password')
                            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                            ->live(debounce: 500)
                            ->same('passwordConfirmation'),
                        Forms\Components\TextInput::make('passwordConfirmation')
                            ->label(__('Confirm Password'))
                            ->password()
                            ->revealable()
                            ->required()
                            ->dehydrated(false),
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('passwordData');
    }

    protected function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        if (!$user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }
        return $user;
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();
        $this->editProfileForm->fill($data);
        $this->editPasswordForm->fill();
    }

    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('updateProfileAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editProfileForm'),
        ];
    }

    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Action::make('updatePasswordAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editPasswordForm'),
        ];
    }

    public function updateProfile(): void
    {
        $data = $this->editProfileForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        $this->sendSuccessNotification();
    }

    public function updatePassword(): void
    {
        $data = $this->editPasswordForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put(['password_hash_' . Filament::getAuthGuard() => $data['password']]);
        }
        $this->editPasswordForm->fill();
        $this->sendSuccessNotification();
    }

    private function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            DB::beginTransaction();

            // $studentModel = $record->student;
            // $employeeModel = $record->employee;

            // if ($studentModel) {
            //     $studentModel->name = $data['name'];
            //     $studentModel->save();
            // }

            // if ($employeeModel) {
            //     $employeeModel->name = $data['name'];
            //     $studentModel->save();
            // }

            $record->update($data);

            DB::commit();
            return $record;
        } catch (Exception $exception) {
            DB::rollBack();
            return $record;
        }
    }

    private function sendSuccessNotification(): void
    {
        Notification::make()
            ->success()
            ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
            ->send();
    }
}
