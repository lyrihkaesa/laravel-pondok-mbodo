<?php

namespace App\Filament\Pages;

use App\Models\Employee;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms\Concerns\InteractsWithForms;

class EditProfileEmployee extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'icon-school-director';
    protected static string $view = 'filament.pages.edit-profile-employee';
    protected static ?string $slug = 'my/pengurus';
    protected static ?int $navigationSort = -97;

    // Custom property
    public ?array $profileData = [];

    // public static function shouldRegisterNavigation(): bool
    // {
    //     return auth()->user()->employee !== null;
    // }

    public static function canAccess(): bool
    {
        return auth()->user()->employee !== null;
    }

    public function getTitle(): string | Htmlable
    {
        return __('Profile Employee');
    }

    public static function getNavigationLabel(): string
    {
        return __('Profile Employee');
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
            'editEmployeeForm',
        ];
    }

    public function editEmployeeForm(Form $form): Form
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
                    // ->aside()
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
                    // ->aside()
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

                    ])
                    ->columns(2),


                Forms\Components\Section::make(__('Academic Information'))
                    // ->aside()
                    ->schema([
                        Forms\Components\TextInput::make('niy')
                            ->label(__('Niy'))
                            ->placeholder(__('Niy Placeholder'))
                            ->unique(ignoreRecord: true)
                            ->disabled(),
                        Forms\Components\TextInput::make('current_name_school')
                            ->label(__('Current Name School'))
                            ->placeholder(__('Current Name School Placeholder')),
                        Forms\Components\DatePicker::make('start_employment_date')
                            ->label(__('Start Employment Date'))
                            ->default(now())
                            ->disabled(),
                        Forms\Components\TextInput::make('salary')
                            ->label(__('Salary'))
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->disabled(),
                        Forms\Components\Repeater::make('homeroomClassrooms')
                            ->label(__('Homeroom Teacher'))
                            ->relationship(name: 'homeroomClassrooms', modifyQueryUsing: fn (Builder $query) => $query->withCount('students'))
                            ->schema([
                                Forms\Components\TextInput::make('combined_name')
                                    ->label(__('Classroom')),
                                Forms\Components\Placeholder::make('students')
                                    ->label(__('Students Count'))
                                    ->content(fn ($record): string => $record ? $record->students_count : '0'),
                            ])
                            ->disabled()
                            ->columns(2)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('roles')
                            ->label(__('Role'))
                            ->options(Role::all()->pluck('name', 'id')->map(function ($name) {
                                return str($name)->replace('_', ' ')->title();
                            }))
                            ->preload()
                            ->multiple()
                            ->searchable()
                            ->disabled(fn () => !$this->getUser()->can('update_role'))
                            ->hintActions([
                                Forms\Components\Actions\Action::make('assignRoleAction')
                                    ->label(__('Update Roles'))
                                    ->badge()
                                    ->icon('heroicon-o-shield-check')
                                    ->color('warning')
                                    ->requiresConfirmation()
                                    ->disabled(fn () => !$this->getUser()->can('update_role'))
                                    ->action(function ($state) {
                                        $this->getUser()->syncRoles([Role::find($state)]);
                                        Notification::make()
                                            ->title(__('Success'))
                                            ->body(__('Role has been updated'))
                                            ->success()
                                            ->send();
                                    }),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2),


                Forms\Components\Section::make(__('Files'))
                    // ->aside()
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
            ])
            ->model($this->getEmployee())
            ->statePath('profileData');
    }

    protected function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        if (!$user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }
        return $user;
    }

    protected function getEmployee(): Model
    {
        return $this->getUser()->employee ?? new Employee();
    }

    protected function fillForms(): void
    {
        $user = $this->getUser();
        $employeeModelArr = $this->getEmployee()->attributesToArray();
        $employeeModelArr['roles'] = $user->roles->pluck('id')->toArray();
        $employeeModelArr['name'] = $user->name;
        // dd($employeeModelArr);
        $this->editEmployeeForm->fill($employeeModelArr);
    }

    protected function getUpdateEmployeeFormActions(): array
    {
        return [
            Action::make('updateEmployeeAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editEmployeeForm'),
        ];
    }

    public function updateEmployee(): void
    {
        $data = $this->editEmployeeForm->getState();
        $this->handleRecordUpdate($this->getEmployee(), $data);
    }

    private function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            DB::beginTransaction();

            $user = $this->getUser();
            $user->name = $data['name'];
            $user->save();

            unset($data['roles']);
            $record->update($data);

            DB::commit();

            Notification::make()
                ->success()
                ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
                ->send();

            return $record;
        } catch (Exception $exception) {
            DB::rollBack();

            Notification::make()
                ->title(__('Failed'))
                ->danger()
                ->send();
            return $record;
        }
    }
}
