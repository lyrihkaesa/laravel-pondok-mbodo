<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use DeviceDetector\DeviceDetector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Enums\SocialMediaVisibility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use App\Services\SocialMediaLinkService;
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

    public ?array $profileData = [];
    public ?array $socialMediaLinkData = [];
    public ?array $passwordData = [];

    public function getTitle(): string | Htmlable
    {
        return __('Profile');
    }

    public static function getNavigationLabel(): string
    {
        return __('Profile');
    }

    public static function getNavigationSort(): ?int
    {
        return \App\Utilities\FilamentUtility::getNavigationSort(__('Profile'));
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
            'editSocialMediaLinkForm',
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
                            ->avatar()
                            ->image()
                            ->imageEditor()
                            ->downloadable()
                            ->openable()
                            ->directory('profile-pictures'),
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
                            ->mask(\Filament\Support\RawJs::make(<<<'JS'
                                $input.replace(/^0/, '62');
                            JS))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\ToggleButtons::make('phone_visibility')
                            ->label(__('Phone Visibility'))
                            ->debounce(delay: 200)
                            ->inline()
                            ->options(SocialMediaVisibility::class)
                            ->default(SocialMediaVisibility::PUBLIC)
                            ->helperText(fn($state) => str((($state instanceof SocialMediaVisibility) ? $state : SocialMediaVisibility::from($state))->getDescription())->markdown()->toHtmlString())
                            ->required(),
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('profileData');
    }

    public function editSocialMediaLinkForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Website and Social Media'))
                    ->description(__('Add your website and links to your social media accounts to provide additional information to visitors of your profile.'))
                    ->aside()
                    ->schema([
                        Forms\Components\Repeater::make('socialMediaLinks')
                            ->label(false)
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('platform')
                                            ->label(__('Platform'))
                                            ->options(\App\Enums\SocialMediaPlatform::class)
                                            ->live(onBlur: true)
                                            ->required(),
                                        Forms\Components\TextInput::make('username')
                                            ->label(__('Username'))
                                            ->placeholder(__('Username Placeholder'))
                                            ->maxLength(255)
                                            ->visible(fn(Forms\Get $get) => $get('platform') !== 'web')
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('url')
                                            ->label(__('URL'))
                                            ->placeholder(__('URL Placeholder'))
                                            ->url()
                                            ->visible(fn(Forms\Get $get) => $get('platform') === 'web')
                                            ->columnSpan(2),
                                    ])
                                    ->columns(3),
                                Forms\Components\ToggleButtons::make('visibility')
                                    ->label(__('Visibility'))
                                    ->debounce(delay: 200)
                                    ->inline()
                                    ->options(SocialMediaVisibility::class)
                                    ->default(SocialMediaVisibility::PUBLIC)
                                    ->helperText(fn($state) => str((($state instanceof SocialMediaVisibility) ? $state : SocialMediaVisibility::from($state))->getDescription())->markdown()->toHtmlString())
                                    ->required(),
                            ]),
                        // ->deleteAction(fn ($action) => $action->requiresConfirmation()),
                    ])
                    ->footerActions([
                        Forms\Components\Actions\Action::make('saveSocialMediaLinks')
                            ->label(__('Save Social Media Links'))
                            ->action(function (Forms\Get $get, $record, SocialMediaLinkService $socialMediaLinkService) {
                                $socialMediaLinks = $get('socialMediaLinks');
                                $userModel = $record;
                                $result = $socialMediaLinkService->insertUpdateDeleteMany($socialMediaLinks, $userModel);

                                if ($result['is_success']) {
                                    Notification::make()
                                        ->success()
                                        ->title(__('Success'))
                                        ->body($result['message'])
                                        ->send();

                                    redirect(self::getUrl());
                                } else {
                                    Notification::make()
                                        ->danger()
                                        ->title(__('Failed'))
                                        ->body($result['message'])
                                        ->send();
                                }
                            }),
                    ])
                    ->footerActionsAlignment(\Filament\Support\Enums\Alignment::End)
                    ->collapsible()
                    ->collapsed(),
            ])
            ->model($this->getUser())
            ->statePath('socialMediaLinkData');
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
                            ->dehydrateStateUsing(fn($state): string => Hash::make($state))
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
            throw new \Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }
        return $user;
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();
        $this->editProfileForm->fill($data);
        $socialMediaLinkData['socialMediaLinks'] = $this->getUser()->socialMediaLinks->toArray();
        $this->editSocialMediaLinkForm->fill($socialMediaLinkData);
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
        } catch (\Exception $exception) {
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

    /**
     * Get the current sessions.
     */
    public function getSessionsProperty(): Collection
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                ->where('user_id', Auth::user()?->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) {
            $deviceDetector = $this->createAgent($session);

            return (object) [
                'device' => $deviceDetector->getDeviceName(),
                'client_name' => $deviceDetector->getClient('name'),
                'os_name' => $deviceDetector->getOs('name'),
                'os_version' => $deviceDetector->getOs('version'),
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     */
    protected function createAgent(mixed $session): DeviceDetector
    {
        $deviceDetector = new DeviceDetector($session->user_agent);
        $deviceDetector->parse();

        return $deviceDetector;
    }

    #[Computed()]
    public function connectedAccounts(): Collection
    {
        return $this->getUser()->connectedAccounts;
    }

    public function connectGoogle(): void
    {
        $this->redirect('/auth/google');
    }

    public function disconnectGoogle($connectedAccountId): void
    {
        $this->getUser()->connectedAccounts()->where('id', $connectedAccountId)->delete();
    }
}
