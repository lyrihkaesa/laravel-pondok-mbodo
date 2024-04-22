<?php

namespace App\Filament\Resources\OrganizationResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';
    protected static ?string $title = 'Struktur Organisasi';

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
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('pivot.role')
                    ->label('Peranan'),
                Tables\Columns\TextColumn::make('pivot.position')
                    ->label('Urutan')
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('role')->required(),
                        Forms\Components\TextInput::make('position')->required()->minValue(1)->numeric()->default(1),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('l')
                    ->form(fn (): array => [
                        // $action->getRecordSelect(),
                        Forms\Components\TextInput::make('role')->required(),
                        Forms\Components\TextInput::make('position')->required()->minValue(1)->numeric()->default(1),
                    ])
                    ->mountUsing(
                        fn ($record, $form) => $form->fill($record->pivot->toArray())
                    )
                    ->using(function (Model $record, array $data): Model {
                        // dd($data);
                        $record->pivot->update($data);
                        return $record;
                    }),
                Tables\Actions\DetachAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
