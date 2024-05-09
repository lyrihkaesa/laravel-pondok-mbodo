<?php

namespace App\Livewire\Ppdb;

use Filament\Forms;
use App\Models\User;
use App\Enums\Gender;
use App\Models\Student;
use Livewire\Component;
use App\Models\Guardian;
use Filament\Forms\Form;
use App\Enums\StudentCategory;
use Illuminate\Support\Facades\DB;
use App\Enums\StudentCurrentSchool;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Concerns\InteractsWithForms;

class Registration extends Component implements HasForms
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
                Forms\Components\Section::make(__('Personal Identity'))
                    ->description(__('Personal Identity Description'))
                    ->aside()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('Full Name'))
                            ->placeholder(__('Full Name Placeholder Student'))
                            ->required(),
                        Forms\Components\TextInput::make('nik')
                            ->label(__('Nik'))
                            ->placeholder(__('Nik Placeholder'))
                            ->required()
                            ->unique()
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
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Address Information'))
                    ->description(__('Address Information Description'))
                    ->aside()
                    ->schema([
                        Forms\Components\Select::make('province')
                            ->label(__('Province'))
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
                            ->label(__('Regency'))
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
                                    ->live()
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
                    ->description(__('Academic Information Description'))
                    ->aside()
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('nisn')
                                    ->label(__('Nisn'))
                                    ->placeholder(__('Nisn Placeholder'))
                                    ->unique(ignoreRecord: true),
                                Forms\Components\TextInput::make('kip')
                                    ->label(__('Kip'))
                                    ->placeholder(__('Kip Placeholder'))
                                    ->unique(ignoreRecord: true),
                            ])
                            ->columns(2),
                        Forms\Components\TextInput::make('current_name_school')
                            ->label(__('Current Name School'))
                            ->placeholder(__('Current Name School Placeholder')),
                        Forms\Components\ToggleButtons::make('category')
                            ->label(__('Category'))
                            ->inline()
                            ->options(StudentCategory::class)
                            ->required()
                            ->live(onBlur: true)
                            ->default(StudentCategory::REGULER),
                        Forms\Components\ToggleButtons::make('current_school')
                            ->label(__('Current School'))
                            ->inline()
                            ->options(StudentCurrentSchool::class)
                            ->required()
                            ->default(StudentCurrentSchool::PAUDTK),
                    ]),

                Forms\Components\Section::make(__('Contact and Security Information'))
                    ->description(__('Contact and Security Information Description'))
                    ->aside()
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label(__('Phone'))
                            ->placeholder(__('Phone Placeholder'))
                            ->required()
                            ->tel()
                            ->helperText(__('Phone Helper Text'))
                            ->unique(table: 'users', column: 'phone', modifyRuleUsing: function (Unique $rule,  Component $livewire, string $operation) {
                                if ($operation === 'edit') {
                                    return $rule->ignore($livewire->data['user_id'], "id");
                                }
                            }),
                        Forms\Components\TextInput::make('email')
                            ->label(__('Email'))
                            ->placeholder(__('Email Placeholder'))
                            ->email()
                            ->unique(table: 'users', column: 'email', modifyRuleUsing: function (Unique $rule,  Component $livewire, string $operation) {
                                if ($operation === 'edit') {
                                    return $rule->ignore($livewire->data['user_id'], "id");
                                }
                            })
                            ->required(),
                        Forms\Components\TextInput::make('password')
                            ->label(__('Password'))
                            ->password()
                            ->revealable()
                            ->helperText(__('Password Helper Text Create')),
                    ])->columns(2),
                Forms\Components\Section::make(__('Parent Information'))
                    ->description(__('Parent Information Description'))
                    ->aside()
                    ->compact()
                    ->schema([
                        Forms\Components\TextInput::make('family_card_number')
                            ->label(__('Family Card Number'))
                            ->placeholder(__('Family Card Number Placeholder'))
                            ->length(16)
                            ->required(),
                        Forms\Components\Section::make(__('Father'))
                            ->schema([
                                Forms\Components\TextInput::make('father_name')
                                    ->label(__('Full Name'))
                                    ->placeholder('Marmin Suparjo')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('father_nik')
                                    ->label(__('Nik'))
                                    ->placeholder(__('Nik Placeholder'))
                                    ->required()
                                    ->length(16),
                                Forms\Components\TextInput::make('father_job')
                                    ->label(__('Job'))
                                    ->placeholder(__('Job Placeholder'))
                                    ->required(),
                                Forms\Components\TextInput::make('father_phone')
                                    ->label(__('Phone'))
                                    ->tel()
                                    ->required()
                                    ->placeholder(__('Phone Placeholder'))
                                    ->helperText(__('Phone Helper Text'))
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('father_address')
                                    ->label(__('Full Address'))
                                    ->placeholder(__('Guardian Full Address Placeholder'))
                                    ->autosize()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Forms\Components\Section::make(__('Mother'))
                            ->schema([
                                Forms\Components\TextInput::make('mother_name')
                                    ->label(__('Full Name'))
                                    ->placeholder('Alis Susanti')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('mother_nik')
                                    ->label(__('Nik'))
                                    ->placeholder(__('Nik Placeholder'))
                                    ->required()
                                    ->length(16),
                                Forms\Components\TextInput::make('mother_job')
                                    ->label(__('Job'))
                                    ->placeholder(__('Job Placeholder'))
                                    ->required(),
                                Forms\Components\TextInput::make('mother_phone')
                                    ->label(__('Phone'))
                                    ->placeholder(__('Phone Placeholder'))
                                    ->helperText(__('Phone Helper Text'))
                                    ->maxLength(18)
                                    ->tel()
                                    ->required(),
                                Forms\Components\Textarea::make('mother_address')
                                    ->label(__('Full Address'))
                                    ->placeholder(__('Guardian Full Address Placeholder'))
                                    ->autosize()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Forms\Components\Section::make(__('Guardian'))
                            ->description(__('Guardian Description'))
                            ->schema([
                                Forms\Components\Repeater::make('guardians')
                                    ->label(false)
                                    ->schema([
                                        Forms\Components\Select::make('relationship')
                                            ->label(__('Relationship'))
                                            ->options([
                                                'Ayah' => '<span class="text-blue-600 dark:text-blue-400">Ayah</span>',
                                                'Ibu' => '<span class="text-pink-600 dark:text-pink-400">Ibu</span>',
                                                'Saudara Laki-Laki' => '<span class="text-amber-600 dark:text-amber-400">Saudara Laki-Laki</span>',
                                                'Saudara Perempuan' => '<span class="text-red-600 dark:text-red-400">Saudara Perempuan</span>',
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
                                            ->required()
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('Full Name'))
                                            ->placeholder(__('Guardian Name Placeholder'))
                                            ->required()
                                            ->maxLength(255),
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
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                    ])
                                    ->defaultItems(0)
                                    // ->collapsed()
                                    ->columns(2)
                                    ->itemLabel(fn (array $state): ?string => $state['relationship'] . ' : ' . $state['name'] ?? null)
                            ])
                    ])
                    ->collapsible(),

                Forms\Components\Section::make(__('Terms and Conditions'))
                    ->description(__('Terms and Conditions Description'))
                    ->aside()
                    ->schema([
                        Forms\Components\Checkbox::make('term_01')
                            ->label('Saya bersedia melunasi biaya pendidikan diawal karena putra/putri kami tidak mendaftar sebagai Santri Ndalem.')
                            ->live(onBlur: true)
                            ->visible(fn (Forms\Get $get) => $get('category') === StudentCategory::REGULER || $get('category') === StudentCategory::BERPRESTASI)
                            ->accepted(fn (Forms\Get $get) => $get('category') === StudentCategory::REGULER || $get('category') === StudentCategory::BERPRESTASI),

                        Forms\Components\Checkbox::make('term_02')
                            ->label('Saya meridhoi putra/putri kami sebagai Santri Ndalem dengan ketentuan - ketentuan yang telah ditetapkan.')
                            ->live()
                            ->visible(fn (Forms\Get $get) => $get('category') === StudentCategory::NDALEM)
                            ->accepted(fn (Forms\Get $get) => $get('category') === StudentCategory::NDALEM),

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

            // Create User
            $user = [
                "name" => $state["name"],
                "email" => $state["email"],
                "phone" => $state["phone"],
                "password" => Hash::make($password),
            ];

            $userModel = User::create($user);

            $userModel->wallets()->create([
                'id' => $userModel->phone,
                'name' => 'Dompet Utama',
                'balance' => 0,
            ]);

            // Assign 'Student' Role
            $roleModel = \Spatie\Permission\Models\Role::where('name', 'santri')->first();
            $userModel->assignRole($roleModel);

            // Membuat santri
            $student = [
                "user_id" => $userModel->id,
                "status" => "Mendaftar",
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
                "postal_code" => $state["postal_code"],
                "nisn" => $state["nisn"],
                "kip" => $state["kip"],
                "current_name_school" => $state["current_name_school"],
                'family_card_number' => $state["family_card_number"],
                "category" => $state["category"],
                "current_school" => $state["current_school"],
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
                    $studentModel->products()->attach($product, ['product_name' => $product->name . ' Awal ' . now()->translatedFormat('F Y'), 'product_price' => $product->price]);
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
        return view('livewire.ppdb.registration');
    }
}
