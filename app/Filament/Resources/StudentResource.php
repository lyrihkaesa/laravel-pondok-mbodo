<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Enums\Gender;
use App\Models\Student;
use App\Models\Guardian;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\StudentStatus;
use App\Enums\StudentCategory;
use Filament\Resources\Resource;
use App\Enums\SocialMediaPlatform;
use App\Enums\StudentCurrentSchool;
use Livewire\Component as Livewire;
use App\Enums\SocialMediaVisibility;
use Illuminate\Validation\Rules\Unique;
use App\Services\SocialMediaLinkService;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class StudentResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Student::class;
    protected static ?string $navigationIcon = 'icon-students';

    public static function getNavigationGroup(): ?string
    {
        return __('Manage Members');
    }

    public static function getNavigationSort(): ?int
    {
        return \App\Utilities\FilamentUtility::getNavigationSort(__('Student'));
    }

    public static function getPluralModelLabel(): string
    {
        return __('Student');
    }

    public static function getModelLabel(): string
    {
        return __('Student');
    }

    public static function form(Form $form): Form
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
                                        })
                                        ->disabled(fn (string $operation): bool => $operation === 'view'),
                                ]),
                            Forms\Components\ToggleButtons::make('gender')
                                ->label(__('Gender'))
                                ->options(Gender::class)
                                ->required()
                                ->default(Gender::MALE)
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
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\FileUpload::make('profile_picture_1x1')
                                    ->label(__('Profile Picture 1x1'))
                                    ->helperText(\App\Utilities\FileUtility::getImageHelperText(suffix: __('Image Helper Suffix')))
                                    ->getUploadedFileNameForStorageUsing(
                                        function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                            return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'profile-picture-1x1');
                                        }
                                    )
                                    ->avatar()
                                    ->image()
                                    ->imageEditor()
                                    ->downloadable()
                                    ->openable()
                                    ->directory('profile_pictures'),
                                Forms\Components\FileUpload::make('user_profile_picture_1x1')
                                    ->label(__('Avatar User'))
                                    ->helperText(\App\Utilities\FileUtility::getImageHelperText())
                                    ->avatar()
                                    ->image()
                                    ->imageEditor()
                                    ->downloadable()
                                    ->openable()
                                    ->directory('profile_pictures'),
                            ])
                            ->columns(2)
                            ->columnSpan(1),
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
                                            ->options(SocialMediaPlatform::class)
                                            ->live(onBlur: true)
                                            ->required(),
                                        Forms\Components\TextInput::make('username')
                                            ->label(__('Username'))
                                            ->placeholder(__('Username Placeholder'))
                                            ->maxLength(255)
                                            ->visible(fn (Forms\Get $get) => $get('platform') !== 'web')
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('url')
                                            ->label(__('URL'))
                                            ->placeholder(__('URL Placeholder'))
                                            ->url()
                                            ->visible(fn (Forms\Get $get) => $get('platform') === 'web')
                                            ->columnSpan(2),
                                    ])
                                    ->columns(3),
                                Forms\Components\ToggleButtons::make('visibility')
                                    ->label(__('Visibility'))
                                    ->debounce(delay: 200)
                                    ->inline()
                                    ->options(SocialMediaVisibility::class)
                                    ->default(SocialMediaVisibility::PUBLIC)
                                    ->helperText(fn ($state) => str((($state instanceof SocialMediaVisibility) ? $state : SocialMediaVisibility::from($state))->getDescription())->markdown()->toHtmlString())
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
                            })
                            ->visible(fn (string $operation): bool => $operation === 'edit'),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->visible(fn (string $operation): bool => $operation === 'edit' || $operation === 'view'),


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
                            ->disabled(fn (Forms\Get $get): bool => $get('province') == null)
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
                            ->searchable(fn (Forms\Get $get): bool => $get('province') != null),
                        Forms\Components\Select::make('district')
                            ->label(__('District'))
                            ->disabled(fn (Forms\Get $get): bool => $get('regency') == null)
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
                            ->searchable(fn (Forms\Get $get): bool => $get('regency') != null),
                        Forms\Components\Select::make('village')
                            ->label(__('Village'))
                            ->disabled(fn (Forms\Get $get): bool => $get('district') == null)
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
                            ->searchable(fn (Forms\Get $get): bool => $get('district') != null),
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
                                            })
                                            ->disabled(fn (string $operation): bool => $operation === 'view'),
                                    ]),
                            ])->columnSpan(1),

                    ])->columns(2),
                Forms\Components\Section::make(__('Academic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('nip')
                            ->label(__('Nip'))
                            ->placeholder(__('Nip Placeholder'))
                            ->unique(ignoreRecord: true),
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
                            ->options(StudentCategory::class)
                            ->required()
                            ->default(StudentCategory::REGULER),
                        Forms\Components\ToggleButtons::make('current_school')
                            ->label(__('Current School'))
                            ->inline()
                            ->options(StudentCurrentSchool::class)
                            ->required()
                            ->default(StudentCurrentSchool::PAUDTK),
                        Forms\Components\ToggleButtons::make('status')
                            ->label(__('Status'))
                            ->inline()
                            ->options(StudentStatus::class)
                            ->required()
                            ->default(StudentStatus::ACTIVE),
                    ])
                    ->columns(2),


                Forms\Components\Section::make(__('Contact and Security Information'))
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label(__('Phone'))
                            ->placeholder(__('Phone Placeholder'))
                            ->required()
                            ->tel()
                            ->helperText(__('Phone Helper Text'))
                            ->unique(table: 'users', column: 'phone', modifyRuleUsing: function (Unique $rule,  Livewire $livewire, string $operation) {
                                if ($operation === 'edit') {
                                    return $rule->ignore($livewire->data['user_id'], "id");
                                }
                            }),
                        Forms\Components\ToggleButtons::make('phone_visibility')
                            ->label(__('Phone Visibility'))
                            ->debounce(delay: 200)
                            ->inline()
                            ->options(SocialMediaVisibility::class)
                            ->default(SocialMediaVisibility::PUBLIC)
                            ->helperText(fn ($state) => str((($state instanceof SocialMediaVisibility) ? $state : SocialMediaVisibility::from($state))->getDescription())->markdown()->toHtmlString())
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label(__('Email'))
                            ->placeholder(__('Email Placeholder'))
                            ->email()
                            ->unique(table: 'users', column: 'email', modifyRuleUsing: function (Unique $rule,  Livewire $livewire, string $operation) {
                                if ($operation === 'edit') {
                                    return $rule->ignore($livewire->data['user_id'], "id");
                                }
                            }),
                        Forms\Components\TextInput::make('password')
                            ->label(__('Password'))
                            ->password()
                            ->revealable()
                            ->helperText(function (string $operation, Forms\Get $get) {
                                if ($operation === 'create') {
                                    return __('Password Helper Text Create');
                                }
                                if ($operation === 'edit') {
                                    return __('Password Helper Text Edit');
                                }
                            }),
                    ])->columns(2),


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
                                    return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'profile-picture-3x4');
                                }
                            )
                            ->image()
                            ->downloadable()
                            ->openable()
                            ->directory('profile_pictures'),
                        Forms\Components\FileUpload::make('profile_picture_4x6')
                            ->label(__('Profile Picture 4x6'))
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText(suffix: __('Image Helper Suffix')))
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'profile-picture-4x6');
                                }
                            )
                            ->image()
                            ->downloadable()
                            ->openable()
                            ->directory('profile_pictures'),
                        Forms\Components\FileUpload::make('birth_certificate')
                            ->label(__('Birth Certificate'))
                            ->helperText(\App\Utilities\FileUtility::getPdfHelperText())
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'akta-kelahiran');
                                }
                            )
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->directory('birth_certificates'),
                        Forms\Components\FileUpload::make('family_card')
                            ->label(__('Family Card'))
                            ->helperText(\App\Utilities\FileUtility::getPdfHelperText())
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'kk');
                                }
                            )
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->directory('family_cards')
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
                                    return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'akta-kelahiran');
                                }
                            )
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->directory('skhun'),
                        Forms\Components\FileUpload::make('ijazah')
                            ->label(__('Ijazah'))
                            ->helperText(\App\Utilities\FileUtility::getPdfHelperText())
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'akta-kelahiran');
                                }
                            )
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->directory('ijazah'),
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
                            ->itemLabel(fn (array $state): ?string => $state['relationship'] . ' : ' . $state['name'] ?? null)
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Livewire $livewire, $record, string $operation): array|null {
                                $guardian = Guardian::where('nik', $data['nik'])
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
                        // ->mutateRelationshipDataBeforeSaveUsing(function (array $data, Livewire $livewire, $record, string $operation): array|null {
                        //     $guardian = Guardian::where('nik', $data['nik'])
                        //         ->where('phone', $data['phone'])
                        //         ->first();
                        //     dump(['Before Save', $data, $livewire->data, $record, $guardian, $operation]);
                        //     // dd(['Before Create', $data, $livewire->data, $record, $guardian]);
                        //     if ($guardian) {
                        //         dump('ini jalan');
                        //         $guardian->students()->syncWithoutDetaching($livewire->data['id']);
                        //         return $data;
                        //     } else {
                        //         return $data;
                        //     }
                        // }),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('user.profile_picture_1x1')
                    ->label(__('Avatar User'))
                    ->circular()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\ImageColumn::make('profile_picture_1x1')
                    ->label(__('Profile Picture 1x1'))
                    ->circular()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Full Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->label(__('Nip Column'))
                    ->badge()
                    ->color('neutral')
                    ->copyable()
                    ->copyMessage(__('Nip Copy Message'))
                    ->copyMessageDuration(1000)
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label(__('Gender'))
                    ->badge()
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('current_school')
                    ->label(__('Current School'))
                    ->badge()
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('user.phone')
                    ->label(__('Phone Column'))
                    ->badge()
                    ->color('success')
                    ->copyable()
                    ->copyMessage(__('Phone Copy Message'))
                    ->copyMessageDuration(1000)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('user.email')
                    ->label(__('Email'))
                    ->searchable()
                    ->copyable()
                    ->copyMessage(__('Email Copy Message'))
                    ->copyMessageDuration(1500)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('status')
                    ->options(StudentStatus::class),
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options(Gender::class),
                Tables\Filters\SelectFilter::make('current_school')
                    ->label('Sekolah')
                    ->options(StudentCurrentSchool::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ClassroomsRelationManager::class,
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'restore',
            'restore_any',
            // 'replicate',
            // 'reorder',
        ];
    }
}
