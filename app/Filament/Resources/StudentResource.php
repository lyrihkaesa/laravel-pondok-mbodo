<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use App\Models\Guardian;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Livewire\Component as Livewire;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen Anggota';
    protected static ?int $navigationSort = -3;

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
                                        }),
                                ]),
                            Forms\Components\ToggleButtons::make('gender')
                                ->label(__('Gender'))
                                ->options([
                                    'Laki-Laki' => __('Male'),
                                    'Perempuan' => __('Female'),
                                ])->colors([
                                    'Laki-Laki' => 'info',
                                    'Perempuan' => 'pink',
                                ])
                                ->required()
                                ->default('Laki-Laki')
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
                            ->options([
                                'Santri Reguler' => __('Santri Reguler'),
                                'Santri Ndalem' => __('Santri Ndalem'),
                                'Santri Berprestasi' => __('Santri Berprestasi'),
                            ])
                            ->colors([
                                'Santri Reguler' => 'info',
                                'Santri Ndalem' => 'warning',
                                'Santri Berprestasi' => 'success',
                            ])
                            ->required()
                            ->default('Santri Reguler'),
                        Forms\Components\ToggleButtons::make('current_school')
                            ->label(__('Current School'))
                            ->inline()
                            ->options([
                                'PAUD/TK' => __('PAUD/TK'),
                                'MI' => __('MI'),
                                'SMP' => __('SMP'),
                                'MA' => __('MA'),
                                'Takhasus' => __('Takhasus'),
                            ])
                            ->colors([
                                'PAUD/TK' => 'pink',
                                'MI' => 'danger',
                                'SMP' => 'warning',
                                'MA' => 'success',
                                'Takhasus' => 'info',
                            ])
                            ->required()
                            ->default('PAUD/TK'),
                        Forms\Components\ToggleButtons::make('status')
                            ->label(__('Status'))
                            ->inline()
                            ->options([
                                'Mendaftar' => __('Enrolled'),
                                'Aktif' => __('Active'),
                                'Lulus' => __('Graduated'),
                                'Tidak Aktif' => __('Inactive'),
                            ])
                            ->colors([
                                'Mendaftar' => 'pink',
                                'Tidak Aktif' => 'danger',
                                'Aktif' => 'success',
                                'Lulus' => 'info',
                            ])
                            ->required()
                            ->default('Aktif'),
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
                    ->color(fn (string $state): string => match ($state) {
                        'Laki-Laki' => 'info',
                        'Perempuan' => 'pink',
                    })
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('current_school')
                    ->label(__('Current School'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PAUD/TK' => 'pink',
                        'MI' => 'danger',
                        'SMP' => 'warning',
                        'MA' => 'success',
                        'Takhasus' => 'info',
                    })
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Mendaftar' => 'pink',
                        'Aktif' => 'success',
                        'Lulus' => 'warning',
                        'Tidak Aktif' => 'danger',
                    })
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
                    ->options([
                        'Mendaftar' => 'Mendaftar',
                        'Aktif' => 'Aktif',
                        'Lulus' => 'Lulus',
                        'Tidak Aktif' => 'Tidak Aktif',
                    ]),
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-Laki' => 'Laki-Laki',
                        'Perempuan' => 'Perempuan',
                    ]),
                Tables\Filters\SelectFilter::make('current_school')
                    ->label('Sekolah')
                    ->options([
                        'PAUD/TK' => 'PAUD/TK',
                        'MI' => 'MI',
                        'SMP' => 'SMP',
                        'MA' => 'MA',
                        'Takhasus' => 'Takhasus',
                    ]),
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
            ]);
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
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return 'Santri';
    }

    public static function getModelLabel(): string
    {
        return 'Santri';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
