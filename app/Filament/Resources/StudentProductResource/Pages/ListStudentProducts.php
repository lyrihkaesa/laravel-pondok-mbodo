<?php

namespace App\Filament\Resources\StudentProductResource\Pages;

use Filament\Forms;
use Filament\Actions;
use App\Models\Wallet;
use App\Models\Product;
use App\Models\Student;
use Livewire\Component;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\StudentProductResource;

class ListStudentProducts extends ListRecords
{
    protected static string $resource = StudentProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->action(function (array $data) {

                    if ($data['validated_at'] !== null) {
                        $data['validated_by'] = auth()->id();
                    }

                    $record = self::getModel()::query()->create($data);

                    $student = $record->student;
                    if ($record->validated_at !== null) {
                        $formWallet = Wallet::findOrFail('SYSTEM');
                        $formWallet->balance -= $record->product_price;
                        $formWallet->save();

                        $toWallet = Wallet::findOrFail('YAYASAN');
                        $toWallet->balance += $record->product_price;
                        $toWallet->save();

                        $toWallet->destinationTransactions()->create([
                            'student_product_id' => $record->id,
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
                    }
                }),
            Actions\Action::make('generateStudentsProducts')
                ->label("Administrasi Umum")
                ->fillForm(fn ($record): array => [
                    'suffix' => now()->format('F Y'),
                ])
                ->form([
                    Forms\Components\TextInput::make('suffix')
                        ->label('Akhiran')
                        ->helperText(fn ($state): string => 'Contoh: Catering ' . $state)
                        ->live(onBlur: true)
                        ->required(),
                    Forms\Components\Select::make('product')
                        ->label('Jenis Biaya')
                        ->relationship('product', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->required(),
                    Forms\Components\Select::make('current_school')
                        ->label('Sekolah')
                        ->options([
                            'PAUD/TK' => 'PAUD/TK',
                            'MI' => 'MI',
                            'SMP' => 'SMP',
                            'MA' => 'MA',
                            'Takhasus' => 'Takhasus',
                        ])
                        ->multiple()
                        ->required(),
                    Forms\Components\Select::make('category')
                        ->label('Kategori')
                        ->options([
                            'Santri Reguler' => 'Santri Reguler',
                            'Santri Ndalem' => 'Santri Ndalem',
                            'Santri Berprestasi' => 'Santri Berprestasi',
                        ])
                        ->multiple()
                        ->required(),
                ])
                ->action(function (Component $livewire): void {
                    $currentSchool = $livewire->mountedActionsData[0]["current_school"];
                    $category = $livewire->mountedActionsData[0]["category"];
                    $students = Student::query()->where('status', '=', 'Aktif')->whereIn('current_school', $currentSchool)->whereIn('category', $category)->get();

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
