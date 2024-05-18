<?php

namespace App\Livewire\Guardian;

use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\StudentProduct;
use Livewire\Attributes\Locked;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListStudentProducts extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    #[Locked]
    public string $studentId;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('Student Financial'))
            ->query(StudentProduct::query()->where('student_id', $this->studentId))
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->label(__('Student Product Name')),
                Tables\Columns\TextColumn::make('product_price')
                    ->label(__('Student Product Price'))
                    ->money('IDR'),
                Tables\Columns\IconColumn::make('is_validated')
                    ->label(__('Is Validated'))
                    ->boolean()
                    ->default(function ($record) {
                        return $record->validated_at === null ? false : true;
                    })
                    ->disabled(),
                Tables\Columns\TextColumn::make('validated_at')
                    ->label(__('Validated At'))
                    ->dateTime(format: 'd/m/Y H:i', timezone: 'Asia/Jakarta'),
                Tables\Columns\TextColumn::make('validator.name')
                    ->label(__('Validated By')),
            ])
            ->filters([
                Tables\Filters\Filter::make('validated_at')
                    ->query(fn (Builder $query): Builder => $query->where('validated_at', null))
                    ->default(true)
                    ->label('Belum Validasi'),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->queryStringIdentifier('products');
    }

    public function render(): View
    {
        return view('livewire.guardian.list-student-products');
    }
}
