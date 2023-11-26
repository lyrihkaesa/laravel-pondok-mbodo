<?php

namespace App\Filament\Resources\StudentProductResource\Pages;

use App\Filament\Resources\StudentProductResource;
use App\Models\Product;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\Component;

class ListStudentProducts extends ListRecords
{
    protected static string $resource = StudentProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('generateStudentsProducts')
                ->label("Generate Masal SPP Santri")
                ->fillForm(fn ($record): array => [
                    'suffix' => now()->format('F Y'),
                ])
                ->form([
                    Forms\Components\TextInput::make('suffix')
                        ->label('Akhiran')
                        ->helperText(fn ($state): string => 'Contoh: Catering ' . $state)
                        ->live()
                        ->required(),
                    Forms\Components\Select::make('product')
                        ->label('Produk')
                        ->relationship('product', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->required(),
                    Forms\Components\Select::make('current_school')
                        ->label('Sekolah')
                        ->options([
                            'PAUD' => 'PAUD',
                            'TK' => 'TK',
                            'SD' => 'SD',
                            'SMP' => 'SMP',
                            'SMK' => 'SMK',
                        ])
                        ->multiple()
                        ->required(),
                ])
                ->action(function (Component $livewire): void {
                    $currentSchool = $livewire->mountedActionsData[0]["current_school"];
                    $students = Student::query()->where('status', '=', 'Aktif')->whereIn('current_school', $currentSchool)->get();

                    $product_ids = $livewire->mountedActionsData[0]["product"];
                    $products = Product::query()->whereIn('id', $product_ids)->get();

                    $suffix = $livewire->mountedActionsData[0]["suffix"];

                    $studentProducts = [];
                    $timestamps = now();

                    foreach ($students as $student) {
                        foreach ($products as $product) {
                            $studentProducts[] = [
                                'student_id' => $student->id,
                                'product_id' => $product->id,
                                'product_name' => $product->name . ' ' . $suffix,
                                'product_price' => $product->price,
                                'created_at' => $timestamps,
                                'updated_at' => $timestamps,
                            ];
                        }
                    }

                    self::getModel()::query()->insert($studentProducts);

                    $product_names = $products->pluck('name')->implode(', ');

                    Notification::make()
                        ->success()
                        ->title('Generate Berhasil')
                        ->body('Santri ' . $students->count() . ' telah dilengkapi dengan SPP ' . $product_names . ' ' . $suffix)
                        ->send();
                }),
        ];
    }
}
