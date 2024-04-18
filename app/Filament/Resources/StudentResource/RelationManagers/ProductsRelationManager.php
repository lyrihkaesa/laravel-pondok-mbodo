<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Tables\Columns\TextColumn::make('product_name'),
                Tables\Columns\TextColumn::make('product_price'),
                Tables\Columns\ToggleColumn::make('validated_at')
                    ->label('Validasi')
                    ->updateStateUsing(function ($state, $record) {
                        $record->pivot->update([
                            'validated_at' => $state ? now() : null,
                            'validated_by' => $state ? auth()->id() : null,
                        ]);
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('validated_by')
                    ->label('Divalidasi oleh')
                    ->formatStateUsing(fn (string $state): string => $state ? User::find($state)->name : '-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')->since()
            ])
            ->filters([
                Tables\Filters\Filter::make('validated_at')->query(fn (Builder $query, array $data): Builder => $query->where('validated_at', null))->default(true)->label('Belum Validasi'),
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
                    Forms\Components\TextInput::make('product_name')->live()->required(),
                    Forms\Components\TextInput::make('product_price')->live()->required(),
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
