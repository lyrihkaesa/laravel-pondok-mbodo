<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Wallet;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\StudentProduct;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentProductResource\Pages;
use App\Filament\Resources\StudentProductResource\RelationManagers;

class StudentProductResource extends Resource
{
    protected static ?string $model = StudentProduct::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Manajemen Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->label(__('Student'))
                    ->required()
                    ->relationship('student', 'name')
                    ->searchable(),
                Forms\Components\Select::make('product_id')
                    ->label(__('Product Name'))
                    ->helperText(__('Product Name Helper Text', [
                        'product_name' => __('Student Product Name'),
                        'product_price' => __('Student Product Price'),
                    ]))
                    ->required()
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                        if ($state === null) {
                            return;
                        };
                        $product = Product::find($state);

                        $set('product_name', $product->name . ' ' . now()->format('F Y'));
                        $set('product_price', $product->price);
                        return $state;
                    }),
                Forms\Components\TextInput::make('product_name')
                    ->label(__('Student Product Name'))
                    ->helperText(__('Student Product Name Helper Text', [
                        'product' => __('Product Name'),
                    ]))
                    ->required(),
                Forms\Components\TextInput::make('product_price')
                    ->label(__('Student Product Price'))
                    ->helperText(__('Student Product Price Helper Text', [
                        'product' => __('Product Name'),
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
                                $set('validated_at', $state ? now(tz: 'Asia/Jakarta')->toDateTimeString() : null);
                                $set('validated_by', $state ? auth()->id() : null);
                                return $state;
                            })
                            ->afterStateHydrated(function (?string $operation, $record, $component) {
                                if ($operation === 'edit') {
                                    $component->state($record->validated_at ? true : false);
                                }
                            })
                            ->disabled(fn (string $operation): bool => $operation === 'edit')
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
                            ->disabled(fn ($state): bool => $state === null)
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
                    ->label(__('Student Product Name')),
                Tables\Columns\TextColumn::make('product_price')
                    ->label(__('Student Product Price'))
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('student.name')
                    ->label(__('Student'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('student.current_school')
                    ->label(__('Student Product School'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PAUD/TK' => 'pink',
                        'MI' => 'danger',
                        'SMP' => 'warning',
                        'MA' => 'success',
                        'Takhasus' => 'info',
                    }),
                Tables\Columns\ToggleColumn::make('is_validated')
                    ->label(__('Is Validated'))
                    ->updateStateUsing(function ($state, $record) {
                        // dd([$state, $record]);
                        $record->update([
                            'validated_at' => $state ? now() : null,
                            'validated_by' => $state ? auth()->id() : null,
                        ]);

                        $student = $record->student;
                        $studentProductId = $record->id;
                        if ($state) {
                            $formWallet = Wallet::findOrFail('SYSTEM');
                            $formWallet->balance -= $record->product_price;
                            $formWallet->save();

                            $toWallet = Wallet::findOrFail('YAYASAN');
                            $toWallet->balance += $record->product_price;
                            $toWallet->save();

                            $toWallet->destinationTransactions()->create([
                                'student_product_id' => $studentProductId,
                                'name' => $record->product_name,
                                'type' => 'credit,validation,system',
                                'amount' => $record->product_price,
                                'from_wallet_id' => $formWallet->id,
                                'description' => auth()->user()->name . ' - ' . auth()->user()->phone . ' melakukan validasi biaya administrasi ' . $student->name . ' #' . $student->id . ' - ' . $student->user->phone,
                            ]);

                            Notification::make()
                                ->title('Melakukan Validasi')
                                ->body('Berhasil melakukan validasi ' . $record->product_name . ' - ' . $student->name)
                                ->success()
                                ->send();

                            return true;
                        } else {
                            $formWallet = Wallet::findOrFail('YAYASAN');
                            $formWallet->balance -= $record->product_price;
                            $formWallet->save();

                            $toWallet = Wallet::findOrFail('SYSTEM');
                            $toWallet->balance += $record->product_price;
                            $toWallet->save();

                            $formWallet->sourceTransactions()->create([
                                'student_product_id' => $studentProductId,
                                'name' => $record->product_name,
                                'type' => 'debit,unvalidation,system',
                                'amount' => $record->product_price,
                                'to_wallet_id' => $toWallet->id,
                                'description' => auth()->user()->name . ' - ' . auth()->user()->phone . ' membatalkan validasi biaya administrasi ' . $student->name . ' #' . $student->id . ' - ' . $student->user->phone,
                            ]);

                            Notification::make()
                                ->title('Membatalkan Validasi')
                                ->body('Berhasil membatalkan validasi ' . $record->product_name . ' - ' . $student->name)
                                ->success()
                                ->iconColor('danger')
                                ->send();

                            return false;
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->since()
                    ->sortable(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record->validated_at === null),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])->defaultSort('validated_at', 'desc');
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
            'index' => Pages\ListStudentProducts::route('/'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return __('Student Financial');
    }

    public static function getModelLabel(): string
    {
        return __('Student Financial');
    }
}
