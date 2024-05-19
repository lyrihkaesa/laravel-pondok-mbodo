<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Classroom;
use Filament\Tables\Table;
use App\Models\AcademicYear;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ClassroomResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClassroomResource\RelationManagers;


class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function getNavigationSort(): ?int
    {
        return \App\Utilities\FilamentUtility::getNavigationSort(__('Classroom'));
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Manage Academic');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Classroom');
    }

    public static function getModelLabel(): string
    {
        return __('Classroom');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Classroom Information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('Name'))
                            ->placeholder(__('Contoh: SMP Kelas 1'))
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                $academicYearId = $get('academic_year_id');
                                if ($academicYearId) {
                                    $academicYear = AcademicYear::find($academicYearId);
                                    $combinedName = $state . ' - ' . ($academicYear ? $academicYear->name : '');
                                    $set('combined_name', $combinedName);
                                } else {
                                    // Atur combined_name menjadi null jika academic_year_id kosong
                                    $set('combined_name', null);
                                }
                            })
                            ->required(),
                        Forms\Components\Select::make('academic_year_id')
                            ->label(__('Academic Year'))
                            ->relationship('academicYear', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
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
                        Forms\Components\Select::make('organization_id')
                            ->label(__('Organization'))
                            ->relationship('organisation', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('combined_name')
                            ->label(__('Combined Name'))
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('homeroom_teacher_id')
                            ->label(__('Homeroom Teacher'))
                            ->required()
                            ->relationship('homeroomTeacher', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Wali Kelas'),
                    ])
                    ->columns(2)
                    ->columnSpan(2),
                Forms\Components\Section::make(__('Classroom Status'))
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('Is Active'))
                            // ->inline(false)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, Forms\Set $set, $record) {
                                $state  ? $set('end_date', null) : $set('end_date', now(tz: 'Asia/Jakarta')->toDateTimeString());
                            })
                            ->afterStateHydrated(function (?string $operation, $record, $component) {
                                if ($operation === 'edit') {
                                    $component->state($record->end_date ? false : true);
                                }
                            }),
                        Forms\Components\DateTimePicker::make('end_date')
                            ->timezone('Asia/Jakarta')
                            ->label(__('End Date'))
                            ->disabled(fn ($state): bool => $state === null),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('combined_name')
                    ->label(__('Combined Name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('organisation.name')
                    ->label(__('Organization'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('homeroomTeacher.name')
                    ->label(__('Homeroom Teacher')),
                Tables\Columns\TextColumn::make('students_count')
                    ->label(__('Students Count'))
                    ->badge()
                    ->color('pink')
                    ->counts('students'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Is Active'))
                    ->boolean()
                    ->default(fn ($record): bool => $record->end_date === null),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->label(__('Is Active'))
                    ->query(fn (Builder $query): Builder => $query->whereNull('end_date'))
                    ->default(true),
                Tables\Filters\SelectFilter::make('academic_year_id')
                    ->label(__('Academic Year'))
                    ->relationship('academicYear', 'name'),
                Tables\Filters\SelectFilter::make('organization_id')
                    ->label(__('Organization'))
                    ->relationship('organisation', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
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
}
