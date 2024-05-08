<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Wallet;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Services\WalletService;
use App\Models\FinancialTransaction;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';
    protected static ?string $title = 'Administrasi';
    protected static ?string $recordTitleAttribute = 'name';
    protected bool $allowsDuplicates = true;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label(__('Product Name'))
                    ->helperText(__('Product Name Helper Text', [
                        'product_name' => __('Student Product Name'),
                        'product_price' => __('Student Product Price'),
                    ]))
                    ->required()
                    ->options(Product::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                        if ($state === null) {
                            return;
                        };
                        $product = Product::find($state);

                        $set('product_name', $product->name . ' ' . now()->translatedFormat('F Y'));
                        $set('product_price', $product->price);
                        return $state;
                    }),
                Forms\Components\TextInput::make('product_name')
                    ->label(__('Student Product Name'))
                    ->required(),
                Forms\Components\TextInput::make('product_price')
                    ->label(__('Student Product Price'))
                    ->required(),
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->label(__('Student Product Name')),
                Tables\Columns\TextColumn::make('product_price')
                    ->label(__('Student Product Price'))
                    ->money('IDR'),
                Tables\Columns\ToggleColumn::make('is_validated')
                    ->label(__('Is Validated'))
                    ->updateStateUsing(function ($state, $record, WalletService $walletService) {
                        // dd([$state, $record, $record->pivot->pivotParent, $record->pivot->id]);
                        $studentProductModel = $record->pivot;

                        $student = $studentProductModel->student;
                        $studentProductId = $studentProductModel->id;
                        $userLogin = auth()->user();
                        if ($state) {
                            $description = $userLogin->name . ' - ' . $userLogin->phone . ' melakukan validasi biaya administrasi ' . $student->name . ' #' . $student->id . ' - ' . $student->user->phone;

                            $financialTransaction = new FinancialTransaction();
                            $financialTransaction->student_product_id = $studentProductId;
                            $financialTransaction->name = $studentProductModel->product_name;
                            $financialTransaction->type = 'credit-yayasan,validation,system';
                            $financialTransaction->description = $description;
                            $result = $walletService->transferSystemToYayasan($studentProductModel->product_price, $financialTransaction);

                            // dd($result);
                            if ($result['is_success'] === false) {
                                Notification::make()
                                    ->title('Melakukan Validasi')
                                    ->body($result['message'])
                                    ->danger()
                                    ->send();

                                return false;
                            } else {
                                $studentProductModel->update([
                                    'validated_at' => now(),
                                    'validated_by' => $userLogin->id,
                                ]);

                                Notification::make()
                                    ->title('Melakukan Validasi')
                                    ->body('Berhasil melakukan validasi ' . $studentProductModel->product_name . ' - ' . $student->name)
                                    ->success()
                                    ->send();

                                return true;
                            }
                        } else {
                            $description = $userLogin->name . ' - ' . $userLogin->phone . ' membatalkan validasi biaya administrasi ' . $student->name . ' #' . $student->id . ' - ' . $student->user->phone;

                            $financialTransaction = new FinancialTransaction();
                            $financialTransaction->student_product_id = $studentProductId;
                            $financialTransaction->name = 'Membatalkan ' . $studentProductModel->product_name;
                            $financialTransaction->type = 'debit-yayasan,unvalidation,system';
                            $financialTransaction->description = $description;
                            $result = $walletService->transferYayasanToSystem($studentProductModel->product_price, $financialTransaction);

                            if ($result['is_success'] === false) {
                                Notification::make()
                                    ->title('Membatalkan Validasi')
                                    ->body($result['message'])
                                    ->danger()
                                    ->send();

                                return true;
                            } else {
                                $studentProductModel->update([
                                    'validated_at' => null,
                                    'validated_by' => null,
                                ]);

                                Notification::make()
                                    ->title('Membatalkan Validasi')
                                    ->body('Berhasil membatalkan validasi ' . $studentProductModel->product_name . ' - ' . $student->name)
                                    ->success()
                                    ->iconColor('danger')
                                    ->send();

                                return false;
                            }
                        }
                    })
                    ->default(function ($record) {
                        return $record->validated_at === null ? false : true;
                    }),
                Tables\Columns\TextColumn::make('validated_at')
                    ->label(__('Validated At'))
                    ->dateTime(format: 'd/m/Y H:i', timezone: 'Asia/Jakarta'),
                Tables\Columns\TextColumn::make('validated_by')
                    ->label(__('Validated By'))
                    ->formatStateUsing(fn (string $state): string => $state ? User::find($state)->name : '-'),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->label('Dibuat')->since()
            ])
            ->filters([
                Tables\Filters\Filter::make('validated_at')
                    ->query(fn (Builder $query, array $data): Builder => $query->where('validated_at', null))
                    ->default(true)
                    ->label('Belum Validasi'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect()
                            // ->options(Product::all()->pluck('name', 'id')) // dont need that because ->allowDuplicates()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                if ($state === null) {
                                    return;
                                };
                                $product = Product::find($state);

                                $set('product_name', $product->name . ' ' . now()->translatedFormat('F Y'));
                                $set('product_price', $product->price);
                            }),
                        Forms\Components\TextInput::make('product_name')
                            ->label(__('Student Product Name'))
                            ->required(),
                        Forms\Components\TextInput::make('product_price')
                            ->label(__('Student Product Price'))
                            ->required(),
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
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record): bool => $record->validated_at === null),
                Tables\Actions\DetachAction::make()
                    ->visible(fn ($record): bool => $record->validated_at === null),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ])
            ->allowDuplicates();
    }

    public static function getPluralModelLabel(): string
    {
        return __('Financial');
    }

    public static function getModelLabel(): string
    {
        return __('Financial');
    }
}
