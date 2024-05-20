<?php

namespace App\Livewire\Guardian;

use Filament\Tables;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\StudentBill;
use Filament\Tables\Table;
use Livewire\Attributes\Locked;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListStudentEnrollments extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    #[Locked]
    public string $studentId;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('Enrollments'))
            ->query(Enrollment::query()->where('student_id', $this->studentId))
            ->columns([
                Tables\Columns\TextColumn::make('classroom.name')
                    ->label(__('Classroom'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('classroom.homeroomTeacher.name')
                    ->label(__('Homeroom Teacher'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Is Active'))
                    ->boolean()
                    ->default(fn ($record): bool => $record->classroom->end_date === null),
                Tables\Columns\TextColumn::make('classroom.end_date')
                    ->label(__('End Date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->label(__('Is Active'))
                    ->query(fn (Builder $query): Builder => $query->whereHas('classroom', function ($query) {
                        $query->whereNull('end_date');
                    }))
                    ->default(true),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public function render(): View
    {
        return view('livewire.guardian.list-student-enrollments');
    }
}
