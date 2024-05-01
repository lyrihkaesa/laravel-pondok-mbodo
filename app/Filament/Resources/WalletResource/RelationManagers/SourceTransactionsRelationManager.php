<?php

namespace App\Filament\Resources\WalletResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SourceTransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sourceTransactions';

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
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->separator(',')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label(__('Amount'))
                    ->prefix(function ($record) {
                        if (str($record->type)->contains('credit')) {
                            return '+';
                        } else {
                            return '-';
                        }
                    })
                    ->color(function ($record) {
                        if (str($record->type)->contains('credit')) {
                            return 'success';
                        } else {
                            return 'danger';
                        }
                    })
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('Description')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->defaultSort('id', 'desc');;
    }
}
