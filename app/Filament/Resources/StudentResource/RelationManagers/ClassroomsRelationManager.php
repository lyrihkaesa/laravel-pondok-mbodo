<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassroomsRelationManager extends RelationManager
{
    protected static string $relationship = 'classrooms';
    protected static ?string $title = 'Kelas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('combined_name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Kelas'),
                Tables\Columns\TextColumn::make('academicYear.name')->label('Tahun Ajaran'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
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
