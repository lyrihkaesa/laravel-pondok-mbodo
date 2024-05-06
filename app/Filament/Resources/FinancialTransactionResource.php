<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Services\WalletService;
use Filament\Resources\Resource;
use App\Models\FinancialTransaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FinancialTransactionResource\Pages;
use App\Filament\Resources\FinancialTransactionResource\RelationManagers;

class FinancialTransactionResource extends Resource
{
    protected static ?string $model = FinancialTransaction::class;
    protected static ?string $navigationGroup = 'Manajemen Keuangan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Wallet'))
                    ->schema([
                        Forms\Components\Select::make('from_wallet_id')
                            ->label(__('From Wallet Id'))
                            ->relationship('fromWallet')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->id} - {$record->name}")
                            ->required()
                            ->searchable(['id', 'name'])
                            ->preload()
                            ->disabled(fn ($operation) => $operation === 'edit'),
                        Forms\Components\Select::make('to_wallet_id')
                            ->label(__('To Wallet Id'))
                            ->relationship('toWallet')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->id} - {$record->name}")
                            ->required()
                            ->searchable(['id', 'name'])
                            ->preload()
                            ->disabled(fn ($operation) => $operation === 'edit'),
                    ])
                    ->compact()
                    ->columns(2),

                Forms\Components\Section::make(__('Detail'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('Name'))
                            ->placeholder(__('Listrik Yayasan / Konsumsi / Lainnya'))
                            ->maxLength(255)
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('amount')
                            ->label(__('Amount'))
                            ->placeholder(__('Amount Placeholder'))
                            ->numeric()
                            ->minValue(1)
                            ->disabled(fn ($operation) => $operation === 'edit')
                            ->required(),
                        Forms\Components\DateTimePicker::make('transaction_at')
                            ->label(__('Transaction At'))
                            ->required()
                            ->default(now(tz: 'Asia/Jakarta')),
                        // Forms\Components\TextInput::make('type')
                        //     ->label(__('Type'))
                        //     ->required(),
                    ])
                    ->compact()
                    ->columns(2),

                Forms\Components\Section::make(__('Other Information'))
                    ->schema([
                        Forms\Components\TextArea::make('description')
                            ->label(__('Description'))
                            ->autoSize(),
                        Forms\Components\FileUpload::make('image_attachments')
                            ->label(__('Image Attachments'))
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText(prefix: 'Masukan bukti transaksi/invoice dalam bentuk gambar.'))
                            ->multiple()
                            ->image()
                            ->directory('financial_transaction_images'),
                        Forms\Components\FileUpload::make('file_attachments')
                            ->label(__('File Attachments'))
                            ->helperText(\App\Utilities\FileUtility::getPdfHelperText(prefix: 'Masukan bukti transaksi/invoice dalam bentuk pdf.'))
                            ->multiple()
                            ->directory('financial_transaction_files'),
                    ])
                    ->compact()
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),
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
                    // ->prefix(function ($record) {
                    //     if (str($record->type)->contains('credit')) {
                    //         return '+';
                    //     } else {
                    //         return '-';
                    //     }
                    // })
                    // ->color(function ($record) {
                    //     if (str($record->type)->contains('credit')) {
                    //         return 'success';
                    //     } else {
                    //         return 'danger';
                    //     }
                    // })
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
                Tables\Actions\EditAction::make()
                    ->action(function (array $data, $record, WalletService $walletService) {
                        dd([$data, $record, $walletService]);
                    }),
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
