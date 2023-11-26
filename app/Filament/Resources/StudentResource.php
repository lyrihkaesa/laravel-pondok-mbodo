<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen Anggota';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi pribadi')
                    ->description('Informasi pribadi yang dimiliki oleh santri')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required(),
                        TextInput::make('address')
                            ->label('Alamat')
                            ->required(),
                        Radio::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-Laki' => 'Laki-Laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required()
                            ->default('Laki-Laki'),
                        DatePicker::make('birth_date')
                            ->required(),
                    ])
                    ->columns(2),
                Section::make('Status Akademik')
                    ->schema([
                        TextInput::make('nis')
                            ->label('Nomor Induk Pesantren')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Radio::make('current_school')
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
                        Radio::make('status')
                            ->label('Status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Lulus' => 'Lulus',
                                'Tidak Aktif' => 'Tidak Aktif',
                            ])
                            ->required()
                            ->default('Aktif'),
                    ])
                    ->columns(2),
                Section::make('Kontak dan keamanan')
                    ->schema([
                        TextInput::make('phone')->required()->placeholder('Contoh: 628123456789')->unique(ignoreRecord: true),
                        TextInput::make('email')->email()->unique(ignoreRecord: true),
                        TextInput::make('password')->password(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nama')->searchable(),
                TextColumn::make('nis')
                    ->label('NIS')
                    ->badge()
                    ->color('neutral')
                    ->copyable()
                    ->copyMessage('Nomor Induk Santri telah disalin!')
                    ->copyMessageDuration(1000)
                    ->searchable(),
                TextColumn::make('gender')->label('Jenis Kelamin')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Laki-Laki' => 'info',
                        'Perempuan' => 'pink',
                    })
                    ->visibleFrom('md'),
                TextColumn::make('current_school')->label('Sekolah')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PAUD' => 'pink',
                        'TK' => 'danger',
                        'SD' => 'warning',
                        'SMP' => 'success',
                        'SMK' => 'info',
                    })
                    ->visibleFrom('md'),
                TextColumn::make('status')->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Lulus' => 'warning',
                        'Tidak Aktif' => 'danger',
                    })
                    ->visibleFrom('md'),
                TextColumn::make('user.phone')
                    ->label('Nomor Telepon')
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('user.email')
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
            RelationManagers\ProductsRelationManager::class
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
