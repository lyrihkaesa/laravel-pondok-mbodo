<?php

namespace App\Filament\Resources\FinancialTransactionResource\Pages;

use Filament\Forms;
use Filament\Actions;
use App\Models\Wallet;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use App\Services\WalletService;
use App\Models\FinancialTransaction;
use Filament\Support\Enums\MaxWidth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\FinancialTransactionResource;

class ManageFinancialTransactions extends ManageRecords
{
    protected static string $resource = FinancialTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->action(function (array $data, WalletService $walletService) {
                    $this->transfer($data, $walletService);
                })
                ->createAnother(false),
            Actions\CreateAction::make('expense')
                ->label(__('Expense'))
                ->color('danger')
                ->icon('heroicon-o-arrow-trending-down')
                ->fillForm(fn (): array => [
                    'from_wallet_id' => Wallet::yayasan()->first()->id,
                    'to_wallet_id' => Wallet::expense()->first()->id,
                    'transaction_at' => now(),
                    'validated_by' => auth()->id(),
                ])
                ->action(function (array $data, WalletService $walletService) {
                    $this->transfer($data, $walletService);
                })
                ->createAnother(false),
            Actions\CreateAction::make('income')
                ->label(__('Income'))
                ->color('success')
                ->icon('heroicon-o-arrow-trending-up')
                ->fillForm(fn (): array => [
                    'from_wallet_id' => Wallet::income()->first()->id,
                    'to_wallet_id' => Wallet::yayasan()->first()->id,
                    'transaction_at' => now(),
                    'validated_by' => auth()->id(),
                ])
                ->action(function (array $data, WalletService $walletService) {
                    $this->transfer($data, $walletService);
                })
                ->createAnother(false),
            Actions\CreateAction::make('dana_bos')
                ->label(__('Dana BOS'))
                ->color('success')
                ->icon('heroicon-o-building-library')
                ->fillForm(fn (): array => [
                    'from_wallet_id' => Wallet::danaBos()->first()->id,
                    'to_wallet_id' => Wallet::yayasan()->first()->id,
                    'transaction_at' => now(),
                    'validated_by' => auth()->id(),
                ])
                ->action(function (array $data, WalletService $walletService) {
                    $this->transfer($data, $walletService);
                })
                ->createAnother(false),
            Actions\Action::make('generate_report_pdf')
                ->label(__('Generate Report PDF'))
                ->color('danger')
                ->icon('heroicon-m-document-text')
                // ->iconButton()
                // ->labeledFrom('md')
                ->model(FinancialTransaction::class)
                ->form([
                    Forms\Components\Select::make('wallet_id')
                        ->label(__('Wallet Id'))
                        ->relationship('fromWallet')
                        ->getOptionLabelFromRecordUsing(fn ($record) => (in_array("ALLOW_NEGATIVE_BALANCE", $record->policy ?? []) ? "🔻" : "")  . "{$record->wallet_code} {$record->name} (" . Number::currency($record->balance, 'IDR', 'id') . ")")
                        ->searchable(['id', 'wallet_code', 'name'])
                        ->preload()
                        ->default(Wallet::yayasan()->first()->id)
                        ->required(),
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\DateTimePicker::make('start_transaction_at')
                                ->label(__('Start Transaction At'))
                                ->default(now()->firstOfMonth())
                                ->required(),
                            Forms\Components\DateTimePicker::make('end_transaction_at')
                                ->label(__('End Transaction At'))
                                ->default(now()->endOfMonth())
                                ->required(),
                        ])
                        ->columns(2),
                    Forms\Components\ToggleButtons::make('month')
                        ->label(__('Month'))
                        ->options(array_combine(range(1, 12), array_map(fn ($month) => Carbon::create(null, $month)->translatedFormat('F'), range(1, 12))))
                        ->inline()
                        ->live()
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            $stateInt = intval($state);

                            $newStart = Carbon::parse($get('start_transaction_at'))->month($stateInt);
                            $newEnd = Carbon::parse($get('end_transaction_at'))->month($stateInt);

                            $set('start_transaction_at', $newStart->toDateTimeString());
                            $set('end_transaction_at', $newEnd->toDateTimeString());
                        })
                        ->default(now()->month),
                ])
                ->action(function (array $data) {
                    $this->replaceMountedAction('viewPdf', arguments: $data);
                })
                ->visible(fn (): bool => auth()->user()->can('export_financial::transaction')),
        ];
    }

    public function viewPdfAction(): Actions\Action
    {
        return  Actions\Action::make('viewPdf')
            ->label(__('View Financial Report'))
            ->modal()
            ->modalContent(fn ($arguments) => view('components.object-pdf', [
                'src' => route('admin.financial-transactions.pdf', $arguments),
            ]))
            ->slideOver()
            ->modalWidth(MaxWidth::FiveExtraLarge)
            // ->closeModalByClickingAway(false)
            ->modalSubmitAction(false)
            ->modalCancelAction(false);
    }

    private function transfer(array $data, WalletService $walletService): void
    {
        $result = $walletService->transfer($data['from_wallet_id'], $data['to_wallet_id'], $data['amount'], new FinancialTransaction($data));

        if ($result['is_success'] === true) {
            Notification::make()
                ->title('Berhasil')
                ->body($result['message'])
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Gagal')
                ->body($result['message'])
                ->danger()
                ->send();
        }
    }
}
