<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Filament\Resources\GuardianResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuardiansRelationManager extends RelationManager
{
    protected static string $relationship = 'guardians';
    protected static ?string $title = 'Orang Tua/Wali';

    public function form(Form $form): Form
    {
        return GuardianResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('relationship')
                    ->label('Hubungan'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Nomor Telepon')
                    ->copyable()
                    ->copyMessage('Nomor Telepon Telah Disalin'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPluralModelLabel(): string
    {
        return 'Orang Tua/Wali';
    }

    public static function getModelLabel(): string
    {
        return 'Orang Tua/Wali';
    }
}
