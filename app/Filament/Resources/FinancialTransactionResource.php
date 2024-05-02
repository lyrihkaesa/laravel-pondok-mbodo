<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancialTransactionResource\Pages;
use App\Filament\Resources\FinancialTransactionResource\RelationManagers;
use App\Models\FinancialTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FinancialTransactionResource extends Resource
{
    protected static ?string $model = FinancialTransaction::class;
    protected static ?string $navigationGroup = 'Manajemen Keuangan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->badge()
                    ->color('neutral')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable()
                    ->copyMessage(__('ID copied!'))
                    ->copyMessageDuration(1500)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('from_wallet_id')
                    ->label(__('From Wallet Id'))
                    ->badge()
                    ->color('danger')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('to_wallet_id')
                    ->label(__('To Wallet Id'))
                    ->badge()
                    ->color('success')
                    ->toggleable(isToggledHiddenByDefault: false),
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
                    ->label(__('Description'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('from_wallet_id')
                    ->label(__('From Wallet Id'))
                    ->relationship('fromWallet', 'id')
                    ->searchable(),
                Tables\Filters\SelectFilter::make('to_wallet_id')
                    ->label(__('To Wallet Id'))
                    ->relationship('toWallet', 'id')
                    ->searchable(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFinancialTransactions::route('/'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return __('Financial Transaction');
    }

    public static function getModelLabel(): string
    {
        return __('Financial Transaction');
    }
}
