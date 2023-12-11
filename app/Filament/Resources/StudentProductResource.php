<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentProductResource\Pages;
use App\Filament\Resources\StudentProductResource\RelationManagers;
use App\Models\Product;
use App\Models\StudentProduct;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentProductResource extends Resource
{
    protected static ?string $model = StudentProduct::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                        if ($state === null) {
                            return;
                        };
                        $product = Product::find($state);

                        $set('product_name', $product->name . ' ' . now()->format('F Y'));
                        $set('product_price', $product->price);
                        return $state;
                    })->live(),
                Forms\Components\TextInput::make('product_name')->required()->live(),
                Forms\Components\TextInput::make('product_price')->required()->live(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_name'),
                Tables\Columns\TextColumn::make('product_price')->money('IDR'),
                Tables\Columns\TextColumn::make('student.name')->searchable(),
                Tables\Columns\TextColumn::make('student.current_school'),
                Tables\Columns\TextColumn::make('student.lastEnrolledClassroom.name'),
                Tables\Columns\ToggleColumn::make('validated_at')
                    ->label('Validasi')
                    ->updateStateUsing(function ($state, $record) {
                        $record->update([
                            'validated_at' => $state ? now() : null,
                            'validated_by' => $state ? auth()->id() : null,
                        ]);
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('validator.name'),
                Tables\Columns\TextColumn::make('created_at')->since()->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('validated_at')
                    ->query(fn (Builder $query, array $data): Builder => $query->where('validated_at', null))
                    ->default(true)
                    ->label('Belum Validasi'),
                Tables\Filters\SelectFilter::make('current_school')
                    ->label('Sekolah')
                    ->options([
                        'PAUD' => 'PAUD',
                        'TK' => 'TK',
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMK' => 'SMK',
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('created_at', 'desc');
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
            'create' => Pages\CreateStudentProduct::route('/create'),
            'edit' => Pages\EditStudentProduct::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return 'Santri Produk';
    }

    public static function getModelLabel(): string
    {
        return 'Santri Produk';
    }
}
