<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Livewire\Component as Livewire;
use Filament\Support\Enums\MaxWidth;
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
                Forms\Components\Section::make('Informasi pribadi')
                    ->description('Informasi pribadi yang dimiliki oleh santri')
                    ->schema([
                        Forms\Components\Grid::make(1)->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->placeholder('Susilo Bambang')
                                ->required(),
                            Forms\Components\TextInput::make('nik')
                                ->label('NIK')
                                ->placeholder('331504090919990001')
                                ->required()
                                ->length(16)
                                // ->helperText(fn (?string $state, Forms\Components\TextInput $component) => strlen($state) . '/' . $component->getMaxLength())
                                ->hintActions([
                                    Forms\Components\Actions\Action::make('autoInputAddress')
                                        ->label('Auto Input Data dari NIK')
                                        ->badge()
                                        ->icon('heroicon-c-paint-brush')
                                        ->color('warning')
                                        ->requiresConfirmation()
                                        ->modalIcon('heroicon-c-paint-brush')
                                        ->modalHeading('Auto Input Data dari NIK')
                                        ->modalDescription('Apakah anda yakin ingin auto input data "Jenis Kelamin, Tempat dan Tanggal Lahir, Provinsi, Kabupaten/Kota, Kecamatan" dari NIK?')
                                        ->modalSubmitActionLabel('Ya, input semuanya')
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
                                ->label('Jenis Kelamin')
                                ->options([
                                    'Laki-Laki' => 'Laki-Laki',
                                    'Perempuan' => 'Perempuan',
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
                                    ->label('Tempat Lahir')
                                    ->placeholder('Grobogan'),
                                Forms\Components\DatePicker::make('birth_date')
                                    ->label('Tanggal Lahir'),
                            ])->columnSpan(1),
                        ])->columnSpan(1),
                        Forms\Components\Grid::make(1)->schema([
                            Forms\Components\FileUpload::make('profile_picture_1x1')
                                ->label('Foto Profil 1x1')
                                ->helperText(\App\Utilities\FileUtility::getImageHelperText())
                                ->getUploadedFileNameForStorageUsing(
                                    function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                        return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'profile-picture-1x1');
                                    }
                                )
                                ->image()
                                ->downloadable()
                                ->openable()
                                ->directory('profile_picture'),
                        ])->columnSpan(1),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Alamat')
                    ->schema([
                        Forms\Components\Select::make('province')
                            ->label('Provinsi')
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
                            ->label('Kabupaten/Kota')
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
                            ->label('Kecamatan')
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
                            ->label('Desa/Kelurahan')
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
                            // ->live()
                            // ->afterStateUpdated(function (?string $state, Forms\Set $set) {
                            //     if ($state !== null) {
                            //         $village = \Creasi\Nusa\Models\Village::where('code', $state)->first();
                            //         if ($village !== null) {
                            //             $set('postcode', $village->postal_code);
                            //         }
                            //     }
                            //     return $state;
                            // })
                            ->searchable(fn (Forms\Get $get): bool => $get('district') != null),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->autosize()
                            ->placeholder('Dusun Sendangsari, Jl Sendangsari'),
                        Forms\Components\Grid::make([
                            'default' => 2,
                            'sm' => 3,
                        ])
                            ->schema([
                                Forms\Components\TextInput::make('rt')
                                    ->label('RT')
                                    ->placeholder('005'),
                                Forms\Components\TextInput::make('rw')
                                    ->label('RW')
                                    ->placeholder('007'),
                                Forms\Components\TextInput::make('postcode')
                                    ->label('Kode Pos')
                                    ->placeholder('58171')
                                    ->suffixActions([
                                        Forms\Components\Actions\Action::make('autoGeneratePostCode')
                                            ->label('Auto Generate Kode Post')
                                            ->badge()
                                            ->iconButton()
                                            ->icon('heroicon-c-paint-brush')
                                            ->color('warning')
                                            ->action(function (Forms\Get $get, Forms\Set $set) {
                                                $villageField = $get('village');
                                                if ($villageField !== null) {
                                                    $village = \Creasi\Nusa\Models\Village::where('code', $villageField)->first();
                                                    if ($village !== null) {
                                                        $set('postcode', $village->postal_code);
                                                    }
                                                }
                                            }),
                                    ])->columnSpan(2),
                            ])->columnSpan(1),

                    ])->columns(2),
                Forms\Components\Section::make('Status Akademik')
                    ->schema([
                        Forms\Components\TextInput::make('nis')
                            ->label('Nomor Induk Pesantren')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('nisn')
                            ->label('NISN (Nomor Induk Siswa Nasional)')
                            ->unique(ignoreRecord: true),
                        Forms\Components\ToggleButtons::make('current_school')
                            ->label('Sekolah')
                            ->inline()
                            ->options([
                                'PAUD' => 'PAUD',
                                'TK' => 'TK',
                                'SD' => 'SD',
                                'SMP' => 'SMP',
                                'SMA' => 'SMA',
                                'SMK' => 'SMK',
                            ])
                            ->required()
                            ->default('PAUD'),
                        Forms\Components\ToggleButtons::make('status')
                            ->label('Status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Lulus' => 'Lulus',
                                'Tidak Aktif' => 'Tidak Aktif',
                            ])
                            ->inline()
                            ->required()
                            ->default('Aktif'),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Kontak dan keamanan')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->required()
                            ->tel()
                            ->placeholder('Contoh: 628123456789')
                            ->unique(table: 'users', column: 'phone', modifyRuleUsing: function (Unique $rule,  Livewire $livewire, string $operation) {
                                if ($operation === 'edit') {
                                    return $rule->ignore($livewire->data['user_id'], "id");
                                }
                            }),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->unique(table: 'users', column: 'email', modifyRuleUsing: function (Unique $rule,  Livewire $livewire, string $operation) {
                                if ($operation === 'edit') {
                                    return $rule->ignore($livewire->data['user_id'], "id");
                                }
                            }),
                        Forms\Components\TextInput::make('password')
                            ->label('Kata Sandi')
                            ->password()
                            ->helperText(function (string $operation, Forms\Get $get) {
                                if ($operation === 'create') {
                                    return 'Jika kata sandi tidak di isi, kata sandi akan dibuat secara automatis, nama depan dengan huruf kecil + 4 angka terakhir nomor telepon + tanggal lahir dengan format: 09092002';
                                }
                                if ($operation === 'edit') {
                                    return 'Jika kata sandi tidak di isi, kata sandi tidak akan diubah';
                                }
                            }),
                    ])->columns(2),
                Forms\Components\Section::make('Berkas')
                    ->schema([
                        Forms\Components\FileUpload::make('profile_picture_3x4')
                            ->label('Foto Profil 3x4')
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText())
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'profile-picture-3x4');
                                }
                            )
                            ->image()
                            ->downloadable()
                            ->openable()
                            ->directory('profile_picture'),
                        Forms\Components\FileUpload::make('profile_picture_4x6')
                            ->label('Foto Profil 4x6')
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText())
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'profile-picture-4x6');
                                }
                            )
                            ->image()
                            ->downloadable()
                            ->openable()
                            ->directory('profile_picture'),
                        Forms\Components\FileUpload::make('birth_certificate')
                            ->label('Akta Kelahiran')
                            ->helperText(\App\Utilities\FileUtility::getPdfHelperText())
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'akta-kelahiran');
                                }
                            )
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->directory('akta_kelahiran'),
                        Forms\Components\FileUpload::make('family_card')
                            ->label('Kartu Keluarga (KK)')
                            ->helperText(\App\Utilities\FileUtility::getPdfHelperText())
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::generateFileName($get('nik'), $file->getFileName(), 'kk');
                                }
                            )
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->directory('kartu_keluarga')
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
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Orang Tua/Wali')
                    ->schema([
                        Forms\Components\Repeater::make('guardians')
                            ->label(false)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('relationship')
                                    ->label('Hubungan Keluarga')
                                    ->native(false)
                                    ->options([
                                        'Ayah' => '<span class="text-blue-600 dark:text-blue-400">Ayah</span>',
                                        'Ibu' => '<span class="text-pink-600 dark:text-pink-400">Ibu</span>',
                                    ])
                                    ->allowHtml(true)
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Hubungan Keluarga')
                                            ->required()
                                            ->placeholder('Paman / Bude / Kakek / Nenek')
                                            ->maxLength(255),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        if (!isset($data['name'])) {
                                            return 'Ayah';
                                        }
                                        return ucwords($data['name']);
                                    })
                                    ->required(),
                                Forms\Components\Textarea::make('address')
                                    ->default(function ($livewire) {
                                        if (isset($livewire->data["address"])) {
                                            return $livewire->data["address"];
                                        }
                                    })
                                    ->label('Alamat')
                                    ->autosize()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Nomor Telepon')
                                    ->tel()
                                    ->required()
                                    ->placeholder('081234567890')
                                    ->maxLength(255),
                            ])
                            ->relationship('guardians')
                            // ->collapsed()
                            ->columns(2)
                            ->itemLabel(fn (array $state): ?string => $state['relationship'] . ' : ' . $state['name'] ?? null)
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->badge()
                    ->color('neutral')
                    ->copyable()
                    ->copyMessage('Nomor Induk Santri telah disalin!')
                    ->copyMessageDuration(1000)
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')->label('Jenis Kelamin')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Laki-Laki' => 'info',
                        'Perempuan' => 'pink',
                    })
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('current_school')->label('Sekolah')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PAUD' => 'pink',
                        'TK' => 'danger',
                        'SD' => 'warning',
                        'SMP' => 'success',
                        'SMK' => 'info',
                    })
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('status')->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Lulus' => 'warning',
                        'Tidak Aktif' => 'danger',
                    })
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('user.phone')
                    ->label('Nomor Telepon')
                    ->searchable()
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Alamat email telah disalin!')
                    ->copyMessageDuration(1500)
                    ->visibleFrom('md'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
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
                        'PAUD' => 'PAUD',
                        'TK' => 'TK',
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMK' => 'SMK',
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
