<?php

namespace App\Livewire;

use Filament\Forms;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Guardian;
use Filament\Forms\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Validation\Rules\Unique;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class StudentRegistrationForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public bool $isSuccessful = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Pribadi')
                    ->description('Informasi tentang data diri calon santri. Klik auto input data dari NIK untuk memasukkan beberapa data secara otomatis.')
                    ->aside()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->placeholder('Ahmad Nur Rohman')
                            ->required(),
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->placeholder('331504090919990001')
                            ->required()
                            ->length(16)
                            ->hintActions([
                                Forms\Components\Actions\Action::make('autoInputAddress')
                                    ->label('Auto Input Data dari NIK')
                                    ->badge()
                                    ->icon('heroicon-c-paint-brush')
                                    ->color('warning')
                                    ->closeModalByClickingAway(false)
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
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi Alamat')
                    ->description('Informasi tempat tinggal calon santri. Klik auto input data dari NIK untuk memasukkan beberapa data secara otomatis.')
                    ->aside()
                    ->schema([
                        Forms\Components\Select::make('province')
                            ->label('Provinsi')
                            ->options(\App\Utilities\NikUtility::$provinces)
                            ->live()
                            ->afterStateUpdated(function (?string $state, ?string $old, Forms\Set $set) {
                                // dd($state);
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
                            ->searchable(fn (Forms\Get $get): bool => $get('district') != null),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->autosize()
                            ->placeholder('Dusun Sendangsari, Jl Sendangsari'),
                        Forms\Components\Grid::make([
                            'default' => 1,
                            'sm' => 3,
                        ])
                            ->schema([
                                Forms\Components\TextInput::make('rt')
                                    ->label('RT')
                                    ->placeholder('005')
                                    ->length(3),
                                Forms\Components\TextInput::make('rw')
                                    ->label('RW')
                                    ->placeholder('007')
                                    ->length(3),
                                Forms\Components\TextInput::make('postcode')
                                    ->label('Kode Pos')
                                    ->placeholder('58171')
                                    ->minLength(5)
                                    ->maxLength(6)
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
                                                    if ($village !== null) {
                                                        $set('postcode', $village->postal_code);
                                                    }
                                                }
                                            }),
                                    ]),
                            ])->columnSpan(1),

                    ])->columns(2),

                Forms\Components\Section::make('Informasi Akademik')
                    ->description('Informasi tentang data akademis calon santri, serta memilih kategori santri dan sekolah.')
                    ->aside()
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('nisn')
                                    ->label('NISN (Nomor Induk Siswa Nasional)')
                                    ->unique(ignoreRecord: true),
                                Forms\Components\TextInput::make('kip')
                                    ->label('KIP (Kartu Indonesia Pintar)')
                                    ->unique(ignoreRecord: true),
                                Forms\Components\TextInput::make('current_name_school')
                                    ->label('Asal Sekolah')
                                    ->placeholder('SD Negeri 2 Danyang'),
                            ])
                            ->columns(3),
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\ToggleButtons::make('category')
                                    ->label('Kategori')
                                    ->inline()
                                    ->options([
                                        'Santri Reguler' => 'Santri Reguler',
                                        'Santri Ndalem' => 'Santri Ndalem',
                                        'Santri Berprestasi' => 'Santri Berprestasi',
                                    ])
                                    ->colors([
                                        'Santri Reguler' => 'info',
                                        'Santri Ndalem' => 'warning',
                                        'Santri Berprestasi' => 'success',
                                    ])
                                    ->required()
                                    ->default('Santri Reguler'),
                                Forms\Components\ToggleButtons::make('current_school')
                                    ->label('Sekolah')
                                    ->inline()
                                    ->options([
                                        'PAUD/TK' => 'PAUD/TK',
                                        'MI' => 'MI',
                                        'SMP' => 'SMP',
                                        'MA' => 'MA',
                                        'Takhasus' => 'Takhasus',
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
                            ]),
                    ]),

                Forms\Components\Section::make('Informasi Kontak dan keamanan')
                    ->description('Digunakan untuk konfirmasi pendafaran dan login sebagai santri.')
                    ->aside()
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Telepon (Whatsapp)')
                            ->required()
                            ->tel()
                            ->placeholder('628123456789')
                            ->helperText('Ganti awalan 0 menjadi 62. Seperti nomor 08123456789 ke 628123456789.')
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
                            ->revealable()
                            ->helperText(function (string $operation, Forms\Get $get) {
                                if ($operation === 'create') {
                                    return 'Jika kata sandi tidak di isi, kata sandi akan dibuat secara automatis, nama depan dengan huruf kecil + 4 angka terakhir nomor telepon + tanggal lahir dengan format: 09092002';
                                }
                                if ($operation === 'edit') {
                                    return 'Jika kata sandi tidak di isi, kata sandi tidak akan diubah';
                                }
                            }),
                    ])->columns(2),
                Forms\Components\Section::make('Informasi Orang Tua')
                    ->description('Informasi tentang data orang tua calon santri.')
                    ->aside()
                    ->compact()
                    ->schema([
                        Forms\Components\TextInput::make('number_family_card')
                            ->label('Nomor KK')
                            ->placeholder('3315042001011492')
                            ->required()
                            ->length(16)
                            ->columnSpanFull(),
                        Forms\Components\Section::make('Ayah')
                            ->schema([
                                Forms\Components\TextInput::make('father_name')
                                    ->label('Nama Lengkap')
                                    ->placeholder('Bambang Susanto')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('father_nik')
                                    ->label('NIK')
                                    ->placeholder('331504090919990001')
                                    ->required()
                                    ->length(16),
                                Forms\Components\TextInput::make('father_job')
                                    ->label('Pekerjaan')
                                    ->placeholder('Petani/Wiraswasta/Wirausaha/dll')
                                    ->required(),
                                Forms\Components\TextInput::make('father_phone')
                                    ->label('Nomor Telepon (Whatsapp)')
                                    ->tel()
                                    ->required()
                                    ->placeholder('6281234567890')
                                    ->helperText('Ganti awalan 0 menjadi 62. Seperti nomor 08123456789 ke 628123456789.')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('father_address')
                                    ->label('Alamat Lengkap')
                                    ->placeholder('Jl. Senangsari, Dusun Sendangsari, RT 005, RW 007, Desa Tambirejo, Kec. Toroh, Kab. Grobogan, Prov. Jawa Tengah.')
                                    ->autosize()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Forms\Components\Section::make('Ibu')
                            ->schema([
                                Forms\Components\TextInput::make('mother_name')
                                    ->label('Nama Lengkap')
                                    ->placeholder('Bambang Susanto')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('mother_nik')
                                    ->label('NIK')
                                    ->placeholder('331504090919990001')
                                    ->required()
                                    ->length(16),
                                Forms\Components\TextInput::make('mother_job')
                                    ->label('Pekerjaan')
                                    ->placeholder('Petani/Wiraswasta/Wirausaha/dll')
                                    ->required(),
                                Forms\Components\TextInput::make('mother_phone')
                                    ->label('Nomor Telepon (Whatsapp)')
                                    ->tel()
                                    ->required()
                                    ->placeholder('6281234567890')
                                    ->helperText('Ganti awalan 0 menjadi 62. Seperti nomor 08123456789 ke 628123456789.')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('mother_address')
                                    ->label('Alamat Lengkap')
                                    ->placeholder('Jl. Senangsari, Dusun Sendangsari, RT 005, RW 007, Desa Tambirejo, Kec. Toroh, Kab. Grobogan, Prov. Jawa Tengah.')
                                    ->autosize()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Forms\Components\Section::make('Wali Lainnya (Opsional)')
                            ->description('Isi ini jika walinya bukan Orang Tua (Ayah dan Ibu).')
                            ->schema([
                                Forms\Components\Repeater::make('guardians')
                                    ->label(false)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nama Lengkap')
                                            ->placeholder('Bambang Susanto')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('relationship')
                                            ->label('Hubungan Keluarga')
                                            ->options([
                                                'Ayah' => '<span class="text-blue-600 dark:text-blue-400">Ayah</span>',
                                                'Ibu' => '<span class="text-pink-600 dark:text-pink-400">Ibu</span>',
                                                'Saudara Laki-Laki' => '<span class="text-amber-600 dark:text-amber-400">Saudara Laki-Laki</span>',
                                                'Saudara Perempuan' => '<span class="text-red-600 dark:text-red-400">Saudara Perempuan</span>',
                                            ])
                                            ->native(false)
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
                                        Forms\Components\TextInput::make('nik')
                                            ->label('NIK')
                                            ->placeholder('331504090919990001')
                                            ->required()
                                            ->length(16),
                                        Forms\Components\TextInput::make('job')
                                            ->label('Pekerjaan')
                                            ->placeholder('Petani/Wiraswasta/Wirausaha/dll')
                                            ->required(),
                                        Forms\Components\TextInput::make('phone')
                                            ->label('Nomor Telepon (Whatsapp)')
                                            ->tel()
                                            ->required()
                                            ->placeholder('6281234567890')
                                            ->helperText('Ganti awalan 0 menjadi 62. Seperti nomor 08123456789 ke 628123456789.')
                                            ->maxLength(255),
                                        Forms\Components\Textarea::make('address')
                                            ->label('Alamat Lengkap')
                                            ->placeholder('Jl. Senangsari, Dusun Sendangsari, RT 005, RW 007, Desa Tambirejo, Kec. Toroh, Kab. Grobogan, Prov. Jawa Tengah.')
                                            ->autosize()
                                            ->maxLength(255),
                                    ])
                                    ->defaultItems(0)
                                    // ->collapsed()
                                    ->columns(2)
                                    ->itemLabel(fn (array $state): ?string => $state['relationship'] . ' : ' . $state['name'] ?? null)
                            ])
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Pernyataan Persetujuan')
                    ->description('Baca dan setujui semua syarat dan ketentuan.')
                    ->aside()
                    ->schema([
                        Forms\Components\Checkbox::make('term_01')
                            ->label('Saya bersedia melunasi biaya pendidikan diawal karena putra/putri kami tidak mendaftar sebagai Santri Ndalem.')
                            ->live(onBlur: true)
                            ->visible(fn (Forms\Get $get) => $get('category') === 'Santri Reguler')
                            ->accepted(fn (Forms\Get $get) => $get('category') === 'Santri Reguler'),

                        Forms\Components\Checkbox::make('term_02')
                            ->label('Saya meridhoi putra/putri kami sebagai Santri Ndalem dengan ketentuan - ketentuan yang telah ditetapkan.')
                            ->live()
                            ->visible(fn (Forms\Get $get) => $get('category') === 'Santri Ndalem')
                            ->accepted(fn (Forms\Get $get) => $get('category') === 'Santri Ndalem'),

                        Forms\Components\Checkbox::make('term_03')
                            ->label('Apabila dikemudian hari putra/putri kami mengundurkan diri dengan alasan apapun, biaya pendidikan yang sudah dibayarkan tidak bisa ditarik kembali.')
                            ->accepted(),

                        Forms\Components\Checkbox::make('term_04')
                            ->label('Sanggup mematuhi tata tertib dan Undang Undang Pondok Pesantren Darul Falah Ki Ageng Mbodo.')
                            ->accepted(),

                        Forms\Components\Checkbox::make('term_05')
                            ->label('Bersedia tinggal di Asrama Pondok dan mengikuti semua kegiatan pesantren.')
                            ->accepted(),

                        Forms\Components\Checkbox::make('term_06')
                            ->label('Mengikuti sistem uang saku Pondok Pesantren Darul Falah Ki Ageng Mbodo.')
                            ->accepted(),

                        Forms\Components\Checkbox::make('term_07')
                            ->label('Dengan mengirim data pendaftaran ini, kami setuju dengan semua peraturan Madrasah dan Pesantren yang berlaku.')
                            ->accepted(),

                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Lainnya')
                    ->aside()
                    ->schema([
                        Forms\Components\Placeholder::make('syarat_pendaftaran')
                            ->content(new HtmlString('
                            <ul class="list-decimal px-4 text-gray-500 dark:text-gray-400">
                                <li>Tiga lembar Fotocopy Kartu Keluarga</li>
                                <li>Tiga lembar Fotocopy Akta Kelahiran</li>
                                <li>Tiga lembar Fotocopy SKHUN Terlegalisir</li>
                                <li>Tiga lembar Fotocopy Ijazah Terlegalisir</li>
                                <li>Tiga lembar Fotocopy KTP Orang Tua/Wali</li>
                                <li>Tiga lembar Pass Foto Berwarna 3x4</li>
                                <li>Tiga lembar Pass Foto Berwarna 2x3</li>
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
        // dd($this->form->getState());
        // dd([$state, $user, $student, $guardians, $this->form->getModel()]);
        $state = $this->form->getState();
        try {
            // Start transaction
            DB::beginTransaction();

            // Generate password
            $password = $state['password'] ?? \App\Utilities\PasswordUtility::generatePassword($state['name'], $state['phone'], $state['birth_date']);
            // dd($password);

            // Membuat user
            $user = [
                "name" => $state["name"],
                "email" => $state["email"],
                "phone" => $state["phone"],
                "password" => Hash::make($password),
            ];

            $userModel = User::create($user);

            // Assign 'Student' Role
            $roleModel = \Spatie\Permission\Models\Role::where('name', 'Santri')->first();
            $userModel->assignRole($roleModel);

            // Membuat santri
            $student = [
                "user_id" => $userModel->id,
                "name" => $state["name"],
                "nik" => $state["nik"],
                "gender" => $state["gender"],
                "birth_place" => $state["birth_place"],
                "birth_date" => $state["birth_date"],
                "province" => $state["province"],
                "regency" => $state["regency"],
                "district" => $state["district"],
                "village" => $state["village"],
                "address" => $state["address"],
                "rt" => $state["rt"],
                "rw" => $state["rw"],
                "postcode" => $state["postcode"],
                "nisn" => $state["nisn"],
                "kip" => $state["kip"],
                "current_name_school" => $state["current_name_school"],
                'number_family_card' => $state["number_family_card"],
                "category" => $state["category"],
                "current_school" => $state["current_school"],
                "status" => "Mendaftar",
            ];

            $studentModel = $this->form->getModel()::create($student);

            // Membuat guardian
            $guardians = [];

            $father = [
                'name' => $state['father_name'],
                "relationship" => "Ayah",
                'nik' => $state['father_nik'],
                'job' => $state['father_job'],
                'phone' => $state['father_phone'],
                'address' => $state['father_address'],
            ];
            $guardians[] = $father;

            $mother = [
                "name" => $state['mother_name'],
                "relationship" => "Ibu",
                "nik" => $state['mother_nik'],
                "job" => $state['mother_job'],
                "phone" => $state['mother_phone'],
                "address" => $state['mother_address'],
            ];
            $guardians[] = $mother;

            // Tambahkan data wali lainnya dari $state['guardians'] ke dalam array guardians
            foreach ($state['guardians'] as $guardian) {
                $guardians[] = $guardian;
            }

            // Proses membuat dan meng-attach guardians ke student
            foreach ($guardians as $guardian) {
                // Cek apakah guardian dengan NIK dan nomor telepon sudah ada dalam database
                $existingGuardian = Guardian::where('nik', $guardian['nik'])
                    ->where('phone', $guardian['phone'])
                    ->first();

                // Jika guardian belum ada, buat guardian baru
                if (!$existingGuardian) {
                    $newGuardian = Guardian::create([
                        'name' => $guardian['name'],
                        'relationship' => $guardian['relationship'],
                        'nik' => $guardian['nik'],
                        'job' => $guardian['job'],
                        'phone' => $guardian['phone'],
                        'address' => $guardian['address'],
                    ]);
                } else {
                    $newGuardian = $existingGuardian;
                }

                // Attach guardian ke student jika belum ter-attach
                if (!$studentModel->guardians->contains($newGuardian)) {
                    $studentModel->guardians()->attach($newGuardian);
                }
            }

            // Melakukan attach products ke student
            $package = \App\Models\Package::with('products')->whereHas('categories', function ($query) use ($state) {
                $query->whereIn('name', ['Biaya Pendaftaran', $state["gender"], $state["category"], $state["current_school"]]);
            }, '=', 4)->first();

            if ($package) {
                foreach ($package->products as $product) {
                    $studentModel->products()->attach($product, ['product_name' => $product->name . ' Awal ' . now()->format('F Y'), 'product_price' => $product->price]);
                }
            }

            // Commit transaction jika tidak ada error
            DB::commit();

            $this->isSuccessful = true;
            $this->dispatch('open-modal', id: 'final-create-student');
        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            // Log error
            Log::error('Error creating student: ' . $e->getMessage());
            // Atau lakukan penanganan error sesuai kebutuhan
            $this->isSuccessful = false;
            $this->dispatch('open-modal', id: 'final-create-student');
        }
    }

    public function render(): View
    {
        return view('livewire.student-registration-form');
    }
}
