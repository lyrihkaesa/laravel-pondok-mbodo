<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Classroom;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ClassroomResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClassroomResource\RelationManagers;
use App\Models\AcademicYear;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Columns\Summarizers\Count;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    protected static ?int $navigationSort = -3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Kelas')
                    ->required()
                    ->placeholder('Contoh: SMP Kelas 1')->live(debounce: 500)->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        $academicYearId = $get('academic_year_id');
                        if ($academicYearId) {
                            $academicYear = AcademicYear::find($academicYearId);
                            $combinedName = $state . ' - ' . ($academicYear ? $academicYear->name : '');
                            $set('combined_name', $combinedName);
                        } else {
                            // Atur combined_name menjadi null jika academic_year_id kosong
                            $set('combined_name', null);
                        }
                    }),
                Select::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->required()
                    ->relationship('academicYear', 'name',  modifyQueryUsing: function (Builder $query) {
                        $query->orderByDesc('name');
                    })
                    ->searchable()
                    ->preload()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        $academicYearId = $state;
                        if ($academicYearId) {
                            $academicYear = AcademicYear::find($academicYearId);
                            $combinedName = $get('name') . ' - ' . ($academicYear ? $academicYear->name : '');
                            $set('combined_name', $combinedName);
                        } else {
                            // Atur combined_name menjadi null jika academic_year_id kosong
                            $set('combined_name', null);
                        }
                    }),
                Select::make('organisation_id')
                    ->label('Organisasi')
                    ->required()
                    ->relationship('organisation', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('combined_name')
                    ->label('Kombinasi Nama')
                    ->required()
                    ->live()
                    ->unique(),
                Select::make('homeroom_teacher_id')
                    ->required()
                    ->relationship('homeroomTeacher', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Wali Kelas'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('organisation.name')
                    ->label('Organisasi'),
                TextColumn::make('homeroomTeacher.name')
                    ->label('Wali Kelas'),
                TextColumn::make('combined_name')
                    ->label('Tahun Ajaran'),
                TextColumn::make('students_count')
                    ->label('Jumlah Siswa')
                    ->badge()
                    ->color('pink')
                    ->counts('students'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassrooms::route('/'),
            'create' => Pages\CreateClassroom::route('/create'),
            'edit' => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return 'Kelas';
    }

    public static function getModelLabel(): string
    {
        return 'Kelas';
    }
}
