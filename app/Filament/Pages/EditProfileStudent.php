<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Livewire\Livewire;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;
use App\Services\SocialMediaLinkService;
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
                Forms\Components\Section::make(__('Personal Information'))
                    ->description(__(
                        'Personal Information Description',
                        [
                            'entity' => __('Student'),
                        ]
                    ))
                    ->schema([
                        Forms\Components\Grid::make(1)->schema([
                            Forms\Components\TextInput::make('name')
                                ->label(__('Full Name'))
                                ->placeholder(__('Full Name Placeholder Student'))
                                ->required(),
                            Forms\Components\TextInput::make('nik')
                                ->label(__('Nik'))
                                ->placeholder(__('Nik Placeholder'))
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->length(16)
                                ->hintActions([
                                    Forms\Components\Actions\Action::make('autoInputFormNik')
                                        ->label(__('Auto Input Form Nik'))
                                        ->badge()
                                        ->icon('heroicon-c-paint-brush')
                                        ->color('warning')
                                        ->requiresConfirmation()
                                        ->modalIcon('heroicon-c-paint-brush')
                                        ->modalHeading(__('Auto Input Form Nik'))
                                        ->modalDescription(__('Auto Input Form Nik Description'))
                                        ->modalSubmitActionLabel(__('Auto Input Form Nik Submit Action Label'))
                                        ->action(function (?String $state, Forms\Get $get, Forms\Set $set) {
                                            if ($state !== null) {
                                                if (strlen($state) === 16) {
                                                    $result = \App\Utilities\NikUtility::parseNIK($state);
                                                    $set('gender', $result->gender);
                                                    $set('province', $result->province);
                                                    $set('regency', $result->regency);
                                                    $set('district', $result->district);
                                                    $set('birth_place', \Creasi\Nusa\Models\Regency::where('code', $result->regency)->first()->name);
                                                    $set('birth_date', $result->birthDate);
                                                }
                                            }
                                        }),
                                ]),
                            Forms\Components\ToggleButtons::make('gender')
                                ->label(__('Gender'))
                                ->options(\App\Enums\Gender::class)
                                ->required()
                                ->default(\App\Enums\Gender::MALE)
                                ->inline(),
                            Forms\Components\Grid::make([
                                'default' => 1,
                                'sm' => 2,
                            ])->schema([
                                Forms\Components\TextInput::make('birth_place')
                                    ->label(__('Birth Place'))
                                    ->placeholder(__('Birth Place Placeholder'))
                                    ->required(),
                                Forms\Components\DatePicker::make('birth_date')
                                    ->label(__('Birth Date'))
                                    ->default(now())
                                    ->required(),
                            ])->columnSpan(1),
                        ])->columnSpan(1),
                        Forms\Components\Grid::make(1)->schema([
                            Forms\Components\FileUpload::make('profile_picture_1x1')
                                ->label(__('Profile Picture 1x1'))
                                ->helperText(\App\Utilities\FileUtility::getImageHelperText(suffix: __('Image Helper Suffix')))
                                ->getUploadedFileNameForStorageUsing(
                                    function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                        return \App\Utilities\FileUtility::getFileName('profile-picture-1x1', $file->getFileName());
                                    }
                                )
                                ->avatar()
                                ->image()
                                ->imageEditor()
                                ->downloadable()
                                ->openable()
                                ->disk(config('filesystems.default'))
                                ->visibility('private')
                                ->directory(fn(Forms\Get $get): string => 'documents/' . $get('nik')),
                        ])->columnSpan(1),
                    ])
                    ->columns(2),


                Forms\Components\Section::make(__('Website and Social Media'))
                    ->id('website-and-social-media')
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
                                    ->options(\App\Enums\SocialMediaVisibility::class)
                                    ->default(\App\Enums\SocialMediaVisibility::PUBLIC)
                                    ->helperText(fn($state) => str((($state instanceof \App\Enums\SocialMediaVisibility) ? $state : \App\Enums\SocialMediaVisibility::from($state))->getDescription())->markdown()->toHtmlString())
                                    ->required(),
                            ]),
                        // ->deleteAction(fn ($action) => $action->requiresConfirmation()),
                    ])
                    ->footerActions([
                        Forms\Components\Actions\Action::make('saveSocialMediaLinks')
                            ->label(__('Save Social Media Links'))
                            ->action(function (Forms\Get $get, $record, SocialMediaLinkService $socialMediaLinkService) {
                                $socialMediaLinks = $get('socialMediaLinks');
                                $userModel = $record->user;
                                $result = $socialMediaLinkService->insertUpdateDeleteMany($socialMediaLinks, $userModel);

                                if ($result['is_success']) {
                                    Notification::make()
                                        ->success()
                                        ->title(__('Success'))
                                        ->body($result['message'])
                                        ->send();

                                    redirect(self::getUrl() . '/' . $record->id . '/edit');
                                } else {
                                    Notification::make()
                                        ->danger()
                                        ->title(__('Failed'))
                                        ->body($result['message'])
                                        ->send();
                                }
                            }),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->visible(fn(string $operation): bool => $operation === 'edit'),


                Forms\Components\Section::make(__('Address Information'))
                    ->schema([
                        Forms\Components\Select::make('province')
                            ->label(__('Province'))
                            ->options(\App\Utilities\NikUtility::$provinces)
                            ->live()
                            ->afterStateUpdated(function (?string $state, ?string $old, Forms\Set $set) {
                                if ($state !== $old) {
                                    $set('regency', NULL);
                                    $set('district', NULL);
                                    $set('village', NULL);
                                }
                                return $state;
                            })
                            ->searchable(),
                        Forms\Components\Select::make('regency')
                            ->label(__('Regency'))
                            ->disabled(fn(Forms\Get $get): bool => $get('province') == null)
                            ->options(function (Forms\Get $get, ?string $state) {
                                if ($get('province') !== null) {
                                    $province = \Creasi\Nusa\Models\Province::where('code', $get('province'))->first();
                                    $regencies = $province->regencies->pluck('name', 'code');
                                    return $regencies;
                                } else {
                                    return [];
                                }
                            })
                            ->live()
                            ->afterStateUpdated(function (?string $state, ?string $old, Forms\Set $set) {
                                if ($state !== $old) {
                                    $set('district', null);
                                    $set('village', null);
                                }
                                return $state;
                            })
                            ->searchable(fn(Forms\Get $get): bool => $get('province') != null),
                        Forms\Components\Select::make('district')
                            ->label(__('District'))
                            ->disabled(fn(Forms\Get $get): bool => $get('regency') == null)
                            ->options(function (?string $state, Forms\Get $get) {
                                if ($get('regency') !== null) {
                                    $regency = \Creasi\Nusa\Models\Regency::where('code', $get('regency'))->first();
                                    $districts = $regency->districts->pluck('name', 'code');
                                    return $districts;
                                } else {
                                    return [];
                                }
                            })
                            ->live()
                            ->afterStateUpdated(function (?string $state, ?string $old, Forms\Set $set) {
                                if ($state !== $old) {
                                    $set('village', null);
                                }
                                return $state;
                            })
                            ->searchable(fn(Forms\Get $get): bool => $get('regency') != null),
                        Forms\Components\Select::make('village')
                            ->label(__('Village'))
                            ->disabled(fn(Forms\Get $get): bool => $get('district') == null)
                            ->options(function (?string $state, Forms\Get $get) {
                                $villages = [];
                                if ($get('district') != null) {
                                    $district = \Creasi\Nusa\Models\District::where('code', $get('district'))->first();
                                    if ($district !== null) {
                                        $villages = $district->villages->pluck('name', 'code');
                                    }
                                }
                                return $villages;
                            })
                            ->searchable(fn(Forms\Get $get): bool => $get('district') != null),
                        Forms\Components\Textarea::make('address')
                            ->label(__('Full Address'))
                            ->autosize()
                            ->placeholder(__('Full Address Placeholder')),
                        Forms\Components\Grid::make([
                            'default' => 1,
                            'sm' => 3,
                        ])
                            ->schema([
                                Forms\Components\TextInput::make('rt')
                                    ->label(__('RT'))
                                    ->placeholder(__('RT Placeholder'))
                                    ->length(3),
                                Forms\Components\TextInput::make('rw')
                                    ->label(__('RW'))
                                    ->placeholder(__('RW Placeholder'))
                                    ->length(3),
                                Forms\Components\TextInput::make('postal_code')
                                    ->label(__('Postal Code'))
                                    ->placeholder(__('Postal Code Placeholder'))
                                    ->minLength(5)
                                    ->maxLength(6)
                                    ->suffixActions([
                                        Forms\Components\Actions\Action::make('autoGeneratePostalCode')
                                            ->label(__('Auto Generate Postal Code'))
                                            ->badge()
                                            ->iconButton()
                                            ->icon('heroicon-c-paint-brush')
                                            ->color('warning')
                                            ->action(function (Forms\Get $get, Forms\Set $set) {
                                                $villageField = $get('village');
                                                if ($villageField !== null) {
                                                    $village = \Creasi\Nusa\Models\Village::where('code', $villageField)->first();
                                                    if ($village !== null) {
                                                        $set('postal_code', $village->postal_code);
                                                    }
                                                }
                                            }),
                                    ]),
                            ])->columnSpan(1),

                    ])->columns(2),
                Forms\Components\Section::make(__('Academic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('nip')
                            ->label(__('Nip'))
                            ->placeholder(__('Nip Placeholder'))
                            ->unique(ignoreRecord: true)
                            ->disabled(),
                        Forms\Components\TextInput::make('nisn')
                            ->label(__('Nisn'))
                            ->placeholder(__('Nisn Placeholder'))
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('kip')
                            ->label(__('Kip'))
                            ->placeholder(__('Kip Placeholder'))
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('current_name_school')
                            ->label(__('Current Name School'))
                            ->placeholder(__('Current Name School Placeholder')),
                        Forms\Components\ToggleButtons::make('category')
                            ->label(__('Category'))
                            ->inline()
                            ->options(\App\Enums\StudentCategory::class)
                            ->required()
                            ->default(\App\Enums\StudentCategory::REGULER)
                            ->disabled(),
                        Forms\Components\ToggleButtons::make('current_school')
                            ->label(__('Current School'))
                            ->inline()
                            ->options(\App\Enums\StudentCurrentSchool::class)
                            ->required()
                            ->default(\App\Enums\StudentCurrentSchool::PAUDTK)
                            ->disabled(),
                        Forms\Components\ToggleButtons::make('status')
                            ->label(__('Status'))
                            ->inline()
                            ->options(\App\Enums\StudentStatus::class)
                            ->required()
                            ->default(\App\Enums\StudentStatus::ACTIVE)
                            ->disabled(),
                    ])
                    ->columns(2),


                Forms\Components\Section::make(__('Files'))
                    ->schema([
                        Forms\Components\TextInput::make('family_card_number')
                            ->label(__('Family Card Number'))
                            ->placeholder(__('Family Card Number Placeholder'))
                            ->required()
                            ->length(16)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('profile_picture_3x4')
                            ->label(__('Profile Picture 3x4'))
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText(suffix: __('Image Helper Suffix')))
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::getFileName('profile-picture-3x4', $file->getFileName());
                                }
                            )
                            ->image()
                            ->downloadable()
                            ->openable()
                            ->disk(config('filesystems.default'))
                            ->visibility('private')
                            ->directory(fn(Forms\Get $get): string => 'documents/' . $get('nik')),
                        Forms\Components\FileUpload::make('profile_picture_4x6')
                            ->label(__('Profile Picture 4x6'))
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText(suffix: __('Image Helper Suffix')))
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::getFileName('profile-picture-4x6', $file->getFileName());
                                }
                            )
                            ->image()
                            ->downloadable()
                            ->openable()
                            ->disk(config('filesystems.default'))
                            ->visibility('private')
                            ->directory(fn(Forms\Get $get): string => 'documents/' . $get('nik')),
                        Forms\Components\FileUpload::make('birth_certificate')
                            ->label(__('Birth Certificate'))
                            ->helperText(\App\Utilities\FileUtility::getPdfHelperText())
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::getFileName('birth-certificate', $file->getFileName());
                                }
                            )
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->disk(config('filesystems.default'))
                            ->visibility('private')
                            ->directory(fn(Forms\Get $get): string => 'documents/' . $get('nik')),
                        Forms\Components\FileUpload::make('family_card')
                            ->label(__('Family Card'))
                            ->helperText(\App\Utilities\FileUtility::getPdfHelperText())
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::getFileName('family-card', $file->getFileName());
                                }
                            )
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->disk(config('filesystems.default'))
                            ->visibility('private')
                            ->directory(fn(Forms\Get $get): string => 'documents/' . $get('nik'))
                            ->hintActions([
                                Forms\Components\Actions\Action::make('preview-fc')
                                    ->label('Lihat Berkas')
                                    ->icon('heroicon-c-eye')
                                    ->color('warning')
                                    // ->iconButton()
                                    ->modal()
                                    ->modalContent(
                                        function (array $state, ?string $operation) {
                                            if (empty($state)) {
                                                return str('Berkas tidak ditemukan!')->toHtmlString();
                                            }

                                            // $value is string | TemporaryUploadedFile
                                            $value = array_values($state)[0];

                                            if ($operation === 'create' && $value instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                                                $url = $value->temporaryUrl();
                                                $iframe = '<iframe src="' . $url . '" height="100%"></iframe>';
                                                return str($iframe)->toHtmlString();
                                            }

                                            if ($operation === 'edit' && is_string($value)) {
                                                $src = asset('storage/' . $value);
                                                $iframe = '<iframe src="' . $src . '" height="100%"></iframe>';
                                                return str($iframe)->toHtmlString();
                                            }
                                        }
                                    )
                                    ->slideOver()
                                    ->modalSubmitAction(false)
                                    ->modalCancelAction(false),
                            ]),
                        Forms\Components\FileUpload::make('skhun')
                            ->label(__('Skhun'))
                            ->helperText(\App\Utilities\FileUtility::getPdfHelperText())
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::getFileName('skhun', $file->getFileName());
                                }
                            )
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->disk(config('filesystems.default'))
                            ->visibility('private')
                            ->directory(fn(Forms\Get $get): string => 'documents/' . $get('nik')),
                        Forms\Components\FileUpload::make('ijazah')
                            ->label(__('Ijazah'))
                            ->helperText(\App\Utilities\FileUtility::getPdfHelperText())
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::getFileName('ijazah', $file->getFileName());
                                }
                            )
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->disk(config('filesystems.default'))
                            ->visibility('private')
                            ->directory(fn(Forms\Get $get): string => 'documents/' . $get('nik')),
                    ])
                    ->columns(2)
                    ->collapsible(),


                Forms\Components\Section::make(__('Parent/Guardian Information'))
                    ->schema([
                        Forms\Components\Repeater::make('guardians')
                            ->label(false)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('Full Name'))
                                    ->placeholder(__('Guardian Name Placeholder'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('relationship')
                                    ->label(__('Relationship'))
                                    ->options([
                                        'Ayah' => '<span class="text-blue-600 dark:text-blue-400">' . __('Father') . '</span>',
                                        'Ibu' => '<span class="text-pink-600 dark:text-pink-400">' . __('Mother') . '</span>',
                                        'Saudara Laki-Laki' => '<span class="text-amber-600 dark:text-amber-400">' . __('Brother') . '</span>',
                                        'Saudara Perempuan' => '<span class="text-red-600 dark:text-red-400">' . __('Sister') . '</span>',
                                    ])
                                    ->native(false)
                                    ->allowHtml(true)
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('relationship')
                                            ->label(__('Relationship'))
                                            ->placeholder(__('Relationship Placeholder'))
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        if (!isset($data['relationship'])) {
                                            return 'Ayah';
                                        }
                                        return ucwords($data['relationship']);
                                    })
                                    ->required(),
                                Forms\Components\TextInput::make('nik')
                                    ->label(__('Nik'))
                                    ->placeholder(__('Nik Placeholder'))
                                    ->required()
                                    ->length(16),
                                Forms\Components\TextInput::make('job')
                                    ->label(__('Job'))
                                    ->placeholder(__('Job Placeholder'))
                                    ->required(),
                                Forms\Components\TextInput::make('phone')
                                    ->label(__('Phone'))
                                    ->placeholder(__('Phone Placeholder'))
                                    ->helperText(__('Phone Helper Text'))
                                    ->maxLength(18)
                                    ->tel()
                                    ->mask(\Filament\Support\RawJs::make(<<<'JS'
                                        $input.replace(/^0/, '62');
                                    JS))
                                    ->required(),
                                Forms\Components\Textarea::make('address')
                                    ->label(__('Full Address'))
                                    ->placeholder(__('Guardian Full Address Placeholder'))
                                    ->autosize()
                                    ->maxLength(255),
                            ])
                            ->relationship('guardians')
                            // ->collapsed()
                            ->columns(2)
                            ->itemLabel(fn(array $state): ?string => $state['relationship'] . ' : ' . $state['name'] ?? null)
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, $record): array|null {
                                $guardian = \App\Models\Guardian::where('nik', $data['nik'])
                                    ->where('phone', $data['phone'])
                                    ->first();
                                // dump(['Before Create', $data, $livewire->data, $record, $guardian, $operation]);
                                // dd(['Before Create', $data, $livewire->data, $record, $guardian, $operation]);
                                // dump($guardian);
                                if ($guardian) {
                                    // dd(['Before Create', $data, $livewire->data, $record->id, $guardian]);
                                    $guardian->students()->syncWithoutDetaching($record->id);
                                    return null;
                                } else {
                                    return $data;
                                }
                            })
                    ])
                    ->collapsible(),
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

            $user = $this->getUser();
            $user->name = $data['name'];
            $user->save();

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
