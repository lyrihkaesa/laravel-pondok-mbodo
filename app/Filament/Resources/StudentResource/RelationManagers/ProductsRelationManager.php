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
use Filament\Notifications\Notification;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource;
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
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
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
                    ->updateStateUsing(function ($state, $record) {
                        // dd([$state, $record, $record->pivot->pivotParent, $record->pivot->id]);
                        $studentProductModel = $record->pivot;
                        $studentProductModel->update([
                            'validated_at' => $state ? now() : null,
                            'validated_by' => $state ? auth()->id() : null,
                        ]);

                        $student = $studentProductModel->student;
                        $studentProductId = $studentProductModel->id;
                        if ($state) {
                            $formWallet = Wallet::findOrFail('SYSTEM');
                            $formWallet->balance -= $record->product_price;
                            $formWallet->save();

                            $toWallet = Wallet::findOrFail('YAYASAN');
                            $toWallet->balance += $record->product_price;
                            $toWallet->save();

                            $toWallet->destinationTransactions()->create([
                                'student_product_id' =>  $studentProductId,
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
                                'student_product_id' =>  $studentProductId,
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
                Tables\Actions\AttachAction::make()->form(fn (AttachAction $action): array => [
                    $action->getRecordSelect()
                        // ->options(Product::all()->pluck('name', 'id')) // dont need that because ->allowDuplicates()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                            if ($state === null) {
                                return;
                            };
                            $product = Product::find($state);

                            $set('product_name', $product->name . ' ' . now()->format('F Y'));
                            $set('product_price', $product->price);
                        }),
                    Forms\Components\TextInput::make('product_name')
                        ->required(),
                    Forms\Components\TextInput::make('product_price')
                        ->required(),
                ])
                    ->preloadRecordSelect(),
            ])
            ->actions([
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
