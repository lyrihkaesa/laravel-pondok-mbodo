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
use Filament\Tables\Actions\AttachAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';
    protected static ?string $title = 'Keuangan';
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
                        $record->pivot->update([
                            'validated_at' => $state ? now() : null,
                            'validated_by' => $state ? auth()->id() : null,
                        ]);

                        if ($state) {
                            $wallet = Wallet::findOrFail('1');
                            $wallet->balance += $record->product_price;
                            $wallet->save();

                            $student = $record->pivot->pivotParent;
                            $wallet->destinationTransactions()->create([
                                'student_product_id' => $record->pivot->id,
                                'name' => $record->product_name,
                                'type' => 'credit,validation,system',
                                'amount' => $record->product_price,
                                'description' => auth()->user()->name . ' - ' . auth()->user()->phone . ' melakukan validasi biaya administrasi ' . $student->name . ' #' . $student->id . ' - ' . $student->user->phone,
                            ]);
                        } else {
                            $wallet = Wallet::findOrFail('1');
                            $wallet->balance -= $record->product_price;
                            $wallet->save();

                            $student = $record->pivot->pivotParent;
                            $wallet->destinationTransactions()->create([
                                'student_product_id' => $record->pivot->id,
                                'name' => $record->product_name,
                                'type' => 'debit,unvalidation,system',
                                'amount' => $record->product_price,
                                'description' => auth()->user()->name . ' - ' . auth()->user()->phone . ' membatalkan validasi biaya administrasi ' . $student->name . ' #' . $student->id . ' - ' . $student->user->phone,
                            ]);
                        }

                        return $state;
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
                Tables\Actions\DetachAction::make(),
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
        return 'Keuangan';
    }

    public static function getModelLabel(): string
    {
        return 'Keuangan';
    }
}
