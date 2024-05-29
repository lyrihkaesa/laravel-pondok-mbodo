<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\StudentBill;
use App\Services\WalletService;
use Filament\Resources\Resource;
use App\Models\FinancialTransaction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentBillResource\Pages;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use App\Filament\Resources\StudentBillResource\RelationManagers;

class StudentBillResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = StudentBill::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function getNavigationSort(): ?int
    {
        return \App\Utilities\FilamentUtility::getNavigationSort(__('Student Financial'));
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Manage Financial');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Student Financial');
    }

    public static function getModelLabel(): string
    {
        return __('Student Financial');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('bill_date_time')
                    ->timezone('Asia/Jakarta')
                    ->label(__('Bill Date'))
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                        if ($state === null) {
                            return;
                        }

                        $product_id = $get('product_id');

                        if ($product_id === null) {
                            return;
                        }

                        $product = Product::find($product_id);

                        $set('product_name', \App\Utilities\FinancialUtility::getProductNameWithDate($product->name, $state));
                        $set('product_price', $product->price);
                        return $state;
                    })
                    ->default(now())
                    ->columnSpanFull(),

                Forms\Components\Select::make('student_id')
                    ->label(__('Student'))
                    ->required()
                    ->relationship('student', 'name')
                    ->searchable(),

                Forms\Components\Select::make('product_id')
                    ->label(__('Product'))
                    ->helperText(__('Product Name Helper Text', [
                        'product_name' => __('Student Product Name'),
                        'product_price' => __('Student Product Price'),
                    ]))
                    ->required()
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                        if ($state === null) {
                            return;
                        };

                        $product = Product::find($state);

                        $set('product_name', \App\Utilities\FinancialUtility::getProductNameWithDate($product->name, $get('bill_date_time')));
                        $set('product_price', $product->price);
                        return $state;
                    }),

                Forms\Components\TextInput::make('product_name')
                    ->label(__('Student Product Name'))
                    ->placeholder(__('Catering Mei 2024'))
                    ->helperText(__('Student Product Name Helper Text', [
                        'product' => __('Product'),
                    ]))
                    ->required(),

                Forms\Components\TextInput::make('product_price')
                    ->label(__('Student Product Price'))
                    ->placeholder(__('100000'))
                    ->helperText(__('Student Product Price Helper Text', [
                        'product' => __('Product'),
                    ]))
                    ->required(),


                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Toggle::make('is_validated')
                            ->label(__('Is Validated'))
                            ->inline(false)
                            ->onColor('success')
                            ->offColor('danger')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, Forms\Set $set, $record) {
                                $set('validated_at', $state ? now()->toDateTimeString() : null);
                                $set('validated_by', $state ? auth()->id() : null);
                                return $state;
                            })
                            ->afterStateHydrated(function (?string $operation, $record, $component) {
                                if ($operation === 'edit') {
                                    $component->state($record->validated_at ? true : false);
                                }
                            })
                            ->disabled(fn (string $operation): bool => $operation === 'edit' || !auth()->user()->can('validate_student::bill'))
                            ->columnSpan([
                                'default' => 1,
                            ]),

                        Forms\Components\DateTimePicker::make('validated_at')
                            ->timezone('Asia/Jakarta')
                            ->label(__('Validated At'))
                            ->helperText(__('Validated At Helper Text Edit'))
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, ?string $old, ?string $operation, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('is_validated', $state ? true : false);
                                    $set('validated_by', $state ? auth()->id() : null);
                                } else if ($operation === 'edit' && $state === null) {
                                    return $old;
                                }
                                return $state;
                            })
                            // ->visible(fn (string $operation): bool => $operation === 'edit')
                            ->disabled(fn ($state): bool => $state === null || !auth()->user()->can('validate_student::bill'))
                            ->columnSpan([
                                'default' => 3,
                            ]),

                        Forms\Components\Select::make('validated_by')
                            ->relationship('validator', 'name')
                            ->label(__('Validated By'))
                            ->disabled()
                            // ->default(auth()->id())
                            // ->visible(fn (string $operation): bool => $operation === 'edit')
                            ->columnSpan([
                                'default' => 3,
                            ]),
                    ])
                    ->columns(7)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->label(__('Student Product Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_price')
                    ->label(__('Student Product Price'))
                    ->money(currency: 'IDR', locale: 'id'),
                Tables\Columns\TextColumn::make('student.name')
                    ->label(__('Student'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('student.current_school')
                    ->label(__('Student Product School'))
                    ->badge(),
                Tables\Columns\ToggleColumn::make('is_validated')
                    ->label(__('Is Validated'))
                    ->updateStateUsing(function ($state, StudentBill $record, WalletService $walletService) {
                        // dd([$state, $record, $walletService]);
                        $studentBillModel = $record;
                        $student = $studentBillModel->student;
                        $studentBillId = $studentBillModel->id;
                        $userLogin = auth()->user();
                        if ($state) {
                            $description = $userLogin->name . ' - ' . $userLogin->phone . ' melakukan validasi biaya administrasi ' . $student->name . ' #' . $student->id . ' - ' . $student->user->phone;

                            $financialTransaction = new FinancialTransaction();
                            $financialTransaction->student_bill_id = $studentBillId;
                            $financialTransaction->name = $studentBillModel->product_name;
                            $financialTransaction->type = 'credit-yayasan,validation,system';
                            $financialTransaction->description = $description;
                            $result = $walletService->transferSystemToYayasan($studentBillModel->product_price, $financialTransaction);

                            // dd($result);
                            if ($result['is_success'] === false) {
                                Notification::make()
                                    ->title('Melakukan Validasi')
                                    ->body($result['message'])
                                    ->danger()
                                    ->send();

                                return false;
                            } else {
                                $studentBillModel->update([
                                    'validated_at' => now(),
                                    'validated_by' => $userLogin->id,
                                ]);

                                Notification::make()
                                    ->title('Melakukan Validasi')
                                    ->body('Berhasil melakukan validasi ' . $studentBillModel->product_name . ' - ' . $student->name)
                                    ->success()
                                    ->send();

                                return true;
                            }
                        } else {
                            $description = $userLogin->name . ' - ' . $userLogin->phone . ' membatalkan validasi biaya administrasi ' . $student->name . ' #' . $student->id . ' - ' . $student->user->phone;

                            $financialTransaction = new FinancialTransaction();
                            $financialTransaction->student_bill_id = $studentBillId;
                            $financialTransaction->name = $studentBillModel->product_name;
                            $financialTransaction->type = 'debit-yayasan,unvalidation,system';
                            $financialTransaction->description = $description;
                            $result = $walletService->transferYayasanToSystem($studentBillModel->product_price, $financialTransaction);

                            if ($result['is_success'] === false) {
                                Notification::make()
                                    ->title('Membatalkan Validasi')
                                    ->body($result['message'])
                                    ->danger()
                                    ->send();

                                return true;
                            } else {
                                $studentBillModel->update([
                                    'validated_at' => null,
                                    'validated_by' => null,
                                ]);

                                Notification::make()
                                    ->title('Membatalkan Validasi')
                                    ->body('Berhasil membatalkan validasi ' . $studentBillModel->product_name . ' - ' . $student->name)
                                    ->success()
                                    ->iconColor('danger')
                                    ->send();

                                return false;
                            }
                        }
                    })
                    ->default(function ($record) {
                        return $record->validated_at === null ? false : true;
                    })
                    ->visible(fn (): bool => auth()->user()->can('validate_student::bill')),
                Tables\Columns\TextColumn::make('validated_at')
                    ->dateTime(format: 'd-m-Y H:i', timezone: 'Asia/Jakarta')
                    ->label(__('Validated At')),
                Tables\Columns\TextColumn::make('validator.name')
                    ->label(__('Validated By')),
                Tables\Columns\TextColumn::make('bill_date_time')
                    ->dateTime(format: 'd-m-Y H:i', timezone: 'Asia/Jakarta')
                    ->label(__('Bill Date')),
            ])
            ->filters([
                Tables\Filters\Filter::make('validated_at')
                    ->query(fn (Builder $query, array $data): Builder => $query->where('validated_at', null))
                    ->default(true)
                    ->label('Belum Validasi'),
                Tables\Filters\SelectFilter::make('current_school')
                    ->label('Sekolah')
                    ->options([
                        'PAUD/TK' => 'PAUD/TK',
                        'MI' => 'MI',
                        'SMP' => 'SMP',
                        'MA' => 'MA',
                        'Takhasus' => 'Takhasus',
                    ])->modifyQueryUsing(
                        function (Builder $query, $data) {
                            if (!$data['values']) {
                                return $query;
                            }
                            return $query->whereHas('student', function (Builder $query) use ($data) {
                                return $query->whereIn('current_school', $data['values']);
                            });
                        }
                    )
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => $record->validated_at === null),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record->validated_at === null),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStudentBills::route('/'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            // 'force_delete',
            // 'force_delete_any',
            // 'restore',
            // 'restore_any',
            // 'replicate',
            // 'reorder',
            'validate',
            'export',
        ];
    }
}
