<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Enums\Gender;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Enums\SocialMediaPlatform;
use Spatie\Permission\Models\Role;
use Livewire\Component as Livewire;
use App\Enums\SocialMediaVisibility;
use Illuminate\Validation\Rules\Unique;
use App\Services\SocialMediaLinkService;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen Anggota';
    protected static ?int $navigationSort = -1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Personal Information'))
                    ->description(__(
                        'Personal Information Description',
                        [
                            'entity' => __('Employee'),
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
                        Forms\Components\Grid::make(1)->schema([
                            Forms\Components\FileUpload::make('profile_picture_1x1')
                                ->label(__('Profile Picture 1x1'))
                                ->helperText(\App\Utilities\FileUtility::getImageHelperText())
                                ->getUploadedFileNameForStorageUsing(
                                    function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                        return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'profile-picture-1x1');
                                    }
                                )
                                ->image()
                                ->downloadable()
                                ->openable()
                                ->directory('profile_pictures'),
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
                            }),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->visible(fn (string $operation): bool => $operation === 'edit'),
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
                                            }),
                                    ]),
                            ])->columnSpan(1),

                    ])->columns(2),
                Forms\Components\Section::make(__('Academic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('niy')
                            ->label(__('Niy'))
                            ->placeholder(__('Niy Placeholder'))
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('current_name_school')
                            ->label(__('Current Name School'))
                            ->placeholder(__('Current Name School Placeholder')),
                        Forms\Components\DatePicker::make('start_employment_date')
                            ->label(__('Start Employment Date'))
                            ->default(now()),
                        Forms\Components\TextInput::make('salary')
                            ->label(__('Salary'))
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        Forms\Components\Repeater::make('homeroomClassrooms')
                            ->label(__('Homeroom Teacher'))
                            ->relationship('homeroomClassrooms')
                            ->schema([
                                Forms\Components\TextInput::make('combined_name')
                                    ->label(__('Classroom')),
                                Forms\Components\Placeholder::make('students')
                                    ->label(__('Students Count'))
                                    ->content(fn ($record): string => $record ? $record->students->count() : '0'),
                            ])
                            ->disabled()
                            ->columns(2)
                            ->columnSpanFull()
                            ->visible(fn (string $operation): bool => $operation === 'edit'),
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
                            ->helperText(fn ($state) => str($state->getDescription())->markdown()->toHtmlString())
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
                        Forms\Components\Select::make('roles')
                            ->label(__('Role'))
                            ->options(Role::whereNotIn('name', ['super_admin'])->pluck('name', 'id'))
                            ->preload()
                            ->multiple()
                            ->searchable(),
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
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText())
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
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText())
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
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Full Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('niy')
                    ->label(__('Niy Column'))
                    ->badge()
                    ->color('neutral')
                    ->copyable()
                    ->copyMessage(__('Niy Copy Message'))
                    ->copyMessageDuration(1000)
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.phone')
                    ->label(__('Phone Column'))
                    ->badge()
                    ->color('success')
                    ->copyable()
                    ->copyMessage(__('Phone Copy Message'))
                    ->copyMessageDuration(1000)
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.roles.name')
                    ->label(__('Role'))
                    ->badge()
                    ->color('warning')
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
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
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereDoesntHave('user.roles', function (Builder $query) {
                    $query->where('name', 'super_admin');
                });
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return 'Pengurus';
    }

    public static function getModelLabel(): string
    {
        return 'Pengurus';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
