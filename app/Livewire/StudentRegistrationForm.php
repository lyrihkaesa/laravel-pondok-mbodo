<?php

namespace App\Livewire;

use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Contracts\View\View;

class StudentRegistrationForm extends Component implements HasForms
{

    use InteractsWithForms;

    public ?array $data = [];

    // public function mount(): void
    // {
    //     $this->form->fill();
    // }

    public function form(Form $form): Form
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
                                        // ->closeModalByClickingAway(false)
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
                            ->afterStateUpdated(function (?string $state, ?string $old, Forms\Set $set) {
                                // dd($state);
                                if ($state !== $old) {
                                    $set('regency', NULL);
                                    $set('district', NULL);
                                    $set('village', NULL);
                                }
                                return $state;
                            })
                            ->live(),
                        // ->searchable(),
                        Forms\Components\Select::make('regency')
                            ->label('Kabupaten/Kota')
                            ->disabled(fn (Forms\Get $get): bool => $get('province') == null)
                            ->options(function (Forms\Get $get, ?string $state) {
                                if ($get('province') !== null) {
                                    $province = \Creasi\Nusa\Models\Province::where('code', $get('province'))->first();
                                    // dd($province);
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
                            }),
                        // ->searchable(fn (Forms\Get $get): bool => $get('province') != null),
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
                            }),
                        // ->searchable(fn (Forms\Get $get): bool => $get('regency') != null),
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
                            }),
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
                        // ->searchable(fn (Forms\Get $get): bool => $get('district') != null),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->autosize()
                            ->placeholder('Dusun Sendangsari, Jl Sendangsari'),
                        Forms\Components\Grid::make([
                            'default' => 1,
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
                                    ->live()
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
                                                    // dd($village);
                                                    if ($village !== null) {
                                                        $set('postcode', $village->postal_code);
                                                        // dd($set('postcode', $village->postal_code));
                                                    }
                                                }
                                            }),
                                    ]),
                            ])->columnSpan(1),

                    ])->columns(2),
                Forms\Components\Section::make('Status Akademik')
                    ->schema([
                        Forms\Components\TextInput::make('nisn')
                            ->label('NISN (Nomor Induk Siswa Nasional)')
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('current_name_school')
                            ->label('Asal Sekolah')
                            ->placeholder('SD/SMP/SMA/SMK Negeri 1 Purwodadi'),
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
                        // Forms\Components\ToggleButtons::make('status')
                        //     ->label('Status')
                        //     ->options([
                        //         'Pendaftaran Awal' => 'Pendaftaran Awal',
                        //         'Pendaftaran Akhir' => 'Pendaftaran Akhir',
                        //         'Aktif' => 'Aktif',
                        //         'Lulus' => 'Lulus',
                        //         'Tidak Aktif' => 'Tidak Aktif',
                        //     ])
                        //     ->inline()
                        //     ->required()
                        //     ->default('Aktif'),
                        Forms\Components\ToggleButtons::make('type')
                            ->label('Tipe')
                            ->options([
                                'Santri Reguler' => 'Santri Reguler',
                                'Santri Khidmah' => 'Santri Khidmah',
                            ])
                            ->inline()
                            ->required()
                            ->default('Santri Reguler')
                            ->live(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Kontak dan keamanan')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->required()
                            ->tel()
                            ->placeholder('Contoh: 628123456789')
                            ->unique(table: 'users', column: 'phone', modifyRuleUsing: function (Unique $rule,  Component $livewire, string $operation) {
                                if ($operation === 'edit') {
                                    return $rule->ignore($livewire->data['user_id'], "id");
                                }
                            }),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->unique(table: 'users', column: 'email', modifyRuleUsing: function (Unique $rule,  Component $livewire, string $operation) {
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
                            ->label('Foto Profil 2x3/4x6')
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText(prefix: 'Pilih salah satu ukuran 2x3 atau 4x6, rekomendasi 4x6. '))
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
                                    ->closeModalByClickingAway(false)
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
                            ->label('SKHUN Terlegalisir')
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
                            ->label('Ijazah Terlegalisir')
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
                // Forms\Components\Section::make('Orang Tua/Wali')
                //     ->schema([
                //         Forms\Components\Repeater::make('guardians')
                //             ->label(false)
                //             ->schema([
                //                 Forms\Components\TextInput::make('name')
                //                     ->label('Nama Lengkap')
                //                     ->required()
                //                     ->maxLength(255),
                //                 Forms\Components\Select::make('relationship')
                //                     ->label('Hubungan Keluarga')
                //                     ->native(false)
                //                     ->options([
                //                         'Ayah' => '<span class="text-blue-600 dark:text-blue-400">Ayah</span>',
                //                         'Ibu' => '<span class="text-pink-600 dark:text-pink-400">Ibu</span>',
                //                     ])
                //                     ->allowHtml(true)
                //                     ->createOptionForm([
                //                         Forms\Components\TextInput::make('name')
                //                             ->label('Hubungan Keluarga')
                //                             ->required()
                //                             ->placeholder('Paman / Bude / Kakek / Nenek')
                //                             ->maxLength(255),
                //                     ])
                //                     ->createOptionUsing(function (array $data) {
                //                         if (!isset($data['name'])) {
                //                             return 'Ayah';
                //                         }
                //                         return ucwords($data['name']);
                //                     })
                //                     ->required(),
                //                 Forms\Components\Textarea::make('address')
                //                     ->default(function ($livewire) {
                //                         if (isset($livewire->data["address"])) {
                //                             return $livewire->data["address"];
                //                         }
                //                     })
                //                     ->label('Alamat')
                //                     ->autosize()
                //                     ->maxLength(255),
                //                 Forms\Components\TextInput::make('phone')
                //                     ->label('Nomor Telepon')
                //                     ->tel()
                //                     ->required()
                //                     ->placeholder('081234567890')
                //                     ->maxLength(255),
                //             ])
                //             ->relationship('guardians')
                //             // ->collapsed()
                //             ->columns(2)
                //             ->itemLabel(fn (array $state): ?string => $state['relationship'] . ' : ' . $state['name'] ?? null)
                //     ])
                //     ->collapsible(),
                Forms\Components\Section::make('Pernyataan Persetujuan')
                    ->schema([
                        Forms\Components\Checkbox::make('term_01')
                            ->label('Saya bersedia melunasi biaya pendidikan diawal karena putra/putri kami tidak mendaftar sebagai Santri Khidmah.')
                            ->live(onBlur: true)
                            ->visible(fn (Forms\Get $get) => $get('type') === 'Santri Reguler'),
                        Forms\Components\Checkbox::make('term_02')
                            ->label('Saya meridhoi putra/putri kami sebagai Santri Khidmah dengan ketentuan - ketentuan yang telah ditetapkan.')
                            ->live()
                            ->visible(fn (Forms\Get $get) => $get('type') === 'Santri Khidmah'),
                        Forms\Components\Checkbox::make('term_03')
                            ->label('Apabila dikemudian hari putra/putri kami mengundurkan diri dengan alasan apapun, biaya pendidikan yang sudah dibayarkan tidak bisa ditarik kembali.'),
                        Forms\Components\Checkbox::make('term_04')
                            ->label('Sanggup mematuhi tata tertib dan Undang Undang Pondok Pesantren Darul Falah Ki Ageng Mbodo.'),
                        Forms\Components\Checkbox::make('term_05')
                            ->label('Bersedia tinggal di Asrama Pondok dan mengikuti semua kegiatan pesantren.'),
                        Forms\Components\Checkbox::make('term_06')
                            ->label('Mengikuti sistem uang saku Pondok Pesantren Darul Falah Ki Ageng Mbodo.'),
                        Forms\Components\Checkbox::make('term_07')
                            ->label('Dengan mengirim data pendaftaran ini, kami setuju dengan semua peraturan Madrasah dan Pesantren yang berlaku.'),

                    ])
                    ->collapsible(),
                Forms\Components\Section::make('Lainnya')
                    ->schema([
                        Forms\Components\Placeholder::make('syarat_pendaftaran')
                            ->content(new HtmlString('
                            <ul class="list-decimal px-4 text-gray-500 dark:text-gray-400">
                                <li>Satu lembar Fotocopy Kartu Keluarga</li>
                                <li>Satu lembar Fotocopy Akta Kelahiran</li>
                                <li>Satu lembar Fotocopy SKHUN Terlegalisir</li>
                                <li>Satu lembar Fotocopy Ijazah Terlegalisir</li>
                                <li>Satu lembar Fotocopy KTP Orang Tua/Wali</li>
                                <li>Masing-masing 6 lembar Pass Foto 3x4 dan 2x3</li>
                            </ul>
                        ')),
                        Forms\Components\Placeholder::make('hubungi')
                            ->content(new HtmlString('
                            <div class="text-gray-500 dark:text-gray-400">
                                <p>Syarat pendaftaran bisa dibawa saat mengantar santri ke pesantren.</p>
                                <p>Setelah mengisi formulir pendaftaran online, harap konfirmasi ke salah satu nomor: </p>
                                <ul class="list-disc px-4">
                                    <li><a class="text-blue-600 dark:text-blue-500" href="#">Mbak Yani : 0882136687558</a></li>
                                    <li><a class="text-blue-600 dark:text-blue-500" href="#">Mbak Ulfa : 0882134125855</a></li>
                                </ul>
                            </div>
                        ')),
                    ])
                    ->collapsible(),
            ])
            ->statePath('data')
            ->model(Student::class);
    }

    public function create(): void
    {
        dd($this->form->getState());
    }

    public function render(): View
    {
        return view('livewire.student-registration-form');
    }
}
