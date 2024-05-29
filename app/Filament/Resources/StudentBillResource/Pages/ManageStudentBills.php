<?php

namespace App\Filament\Resources\StudentBillResource\Pages;

use Filament\Forms;
use Filament\Actions;
use App\Models\Wallet;
use App\Models\Product;
use App\Models\Student;
use Livewire\Component;
use App\Enums\StudentCategory;
use App\Models\StudentBill;
use App\Services\WalletService;
use App\Enums\StudentCurrentSchool;
use App\Models\FinancialTransaction;
use Filament\Support\Enums\MaxWidth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\StudentBillResource;

class ManageStudentBills extends ManageRecords
{
    protected static string $resource = StudentBillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->action(function (array $data, WalletService $walletService) {
                    $userLogin = auth()->user();
                    if ($data['is_validated']) {
                        $data['validated_by'] = $userLogin->id;
                    }

                    $record = self::getModel()::query()->create($data);

                    $student = $record->student;
                    $studentBillId = $record->id;
                    if ($record->validated_at !== null) {
                        $description = $userLogin->name . ' - ' . $userLogin->phone . ' melakukan validasi biaya administrasi ' . $student->name . ' #' . $student->id . ' - ' . $student->user->phone;

                        $financialTransaction = new FinancialTransaction();

                        $financialTransaction->student_bill_id = $studentBillId;
                        $financialTransaction->name = $record->product_name;
                        $financialTransaction->type = 'credit-yayasan,validation,system';
                        $financialTransaction->description = $description;
                        $walletService->transferSystemToYayasan($record->product_price, $financialTransaction);

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
                    'suffix' => now()->translatedFormat('M Y'),
                    'bill_date_time' => now()->toDateTimeString(),
                    'category' => [StudentCategory::REGULER],
                ])
                ->form([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\DateTimePicker::make('bill_date_time')
                                ->timezone('Asia/Jakarta')
                                ->label(__('Bill Date'))
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                    $set('suffix', \Illuminate\Support\Carbon::parse($state)->translatedFormat('M Y'));
                                })
                                ->required(),

                            Forms\Components\TextInput::make('suffix')
                                ->label('Akhiran')
                                ->helperText(fn ($state): string => 'Contoh: Catering ' . $state)
                                ->live(onBlur: true)
                                ->required(),
                        ]),


                    Forms\Components\Select::make('product')
                        ->label(__('Student Product Name'))
                        ->relationship('product', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->required(),


                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Select::make('current_school')
                                ->label(__('Student Product School'))
                                ->options(StudentCurrentSchool::class)
                                ->multiple()
                                ->required(),

                            Forms\Components\Select::make('category')
                                ->label(__('Category'))
                                ->options(StudentCategory::class)
                                ->multiple()
                                ->required(),
                        ]),
                ])
                ->action(function (Component $livewire, array $data): void {
                    $currentSchool = $livewire->mountedActionsData[0]["current_school"];
                    $category = $livewire->mountedActionsData[0]["category"];
                    $students = Student::query()
                        ->where('status', '=', 'Aktif')
                        ->whereIn('current_school', $currentSchool)
                        ->whereIn('category', $category)
                        ->get();

                    $product_ids = $livewire->mountedActionsData[0]["product"];
                    $products = Product::query()
                        ->whereIn('id', $product_ids)
                        ->get();

                    $billDateTimeString = $livewire->mountedActionsData[0]["bill_date_time"];
                    $billDateTime = \Illuminate\Support\Carbon::parse($billDateTimeString, 'Asia/Jakarta')->setTimezone('UTC');
                    $suffix = $livewire->mountedActionsData[0]["suffix"];

                    $studentBills = [];
                    $nowTimestamp = now();

                    foreach ($students as $student) {
                        foreach ($products as $product) {
                            $studentBills[] = [
                                'bill_date_time' => $billDateTime,
                                'student_id' => $student->id,
                                'product_id' => $product->id,
                                'product_name' => $product->name . ' ' . $suffix,
                                'product_price' => $product->price,
                                'updated_at' => $nowTimestamp, // Karena menggunakan insert bukan create jadi perlu masukan updated_at
                                'created_at' => $nowTimestamp, // Karena menggunakan insert bukan create jadi perlu masukan updated_at
                            ];
                        }
                    }

                    self::getModel()::query()->insert($studentBills);

                    $product_names = $products->pluck('name')->implode(', ');

                    Notification::make()
                        ->success()
                        ->title('Generate Administrasi Santri Berhasil')
                        ->body($students->count() . ' Santri ditambahkan Tagihan "' . $product_names . '" (' . $suffix . ') by ' . auth()->user()->name)
                        ->send()
                        ->sendToDatabase(\App\Models\User::withOut(['roles'])
                            ->whereHas('roles.permissions', function ($query) {
                                $query->where('name', 'create_student::bill');
                            })
                            ->get());
                })
                ->visible(fn (): bool => auth()->user()->can('create_student::bill')),


            Actions\Action::make('generateReportPdf')
                ->label(__('Generate Report PDF'))
                ->color('danger')
                ->icon('heroicon-m-document-text')
                // ->iconButton()
                // ->labeledFrom('md')
                ->model(StudentBill::class)
                ->form([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Select::make('current_school')
                                ->label(__('Student Product School'))
                                ->options(StudentCurrentSchool::class)
                                ->multiple()
                                ->required(),
                            Forms\Components\Select::make('category')
                                ->label(__('Category'))
                                ->options(StudentCategory::class)
                                ->multiple()
                                ->required(),
                        ]),
                ])
                ->action(function (array $data) {
                    $this->replaceMountedAction('viewPdf', arguments: $data);
                })
                ->visible(fn (): bool => auth()->user()->can('export_student::bill')),
        ];
    }

    public function viewPdfAction(): Actions\Action
    {
        return  Actions\Action::make('viewPdf')
            ->label(__('View Student Bill'))
            ->modal()
            ->modalContent(fn ($arguments) => view('components.object-pdf', [
                'src' => route('admin.student-bill.pdf', $arguments),
            ]))
            ->slideOver()
            ->modalWidth(MaxWidth::FiveExtraLarge)
            // ->closeModalByClickingAway(false)
            ->modalSubmitAction(false)
            ->modalCancelAction(false);
    }
}
