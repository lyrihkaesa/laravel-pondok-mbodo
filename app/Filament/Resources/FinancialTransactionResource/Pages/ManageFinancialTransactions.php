<?php

namespace App\Filament\Resources\FinancialTransactionResource\Pages;

use Filament\Forms;
use Filament\Actions;
use Filament\Forms\Form;
use Illuminate\Support\Number;
use App\Services\WalletService;
use App\Models\FinancialTransaction;
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
                }),
            Actions\CreateAction::make('expense')
                ->label(__('Expense'))
                ->color('danger')
                ->icon('heroicon-o-arrow-trending-down')
                ->fillForm(fn (): array => [
                    'from_wallet_id' => 'YAYASAN',
                    'to_wallet_id' => 'EXPENSE',
                    'transaction_at' => now(),
                    'validated_by' => auth()->id(),
                ])
                ->action(function (array $data, WalletService $walletService) {
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
                }),
            Actions\CreateAction::make('income')
                ->label(__('Income'))
                ->color('success')
                ->icon('heroicon-o-arrow-trending-up')
                ->fillForm(fn (): array => [
                    'from_wallet_id' => 'INCOME',
                    'to_wallet_id' => 'YAYASAN',
                    'transaction_at' => now(),
                    'validated_by' => auth()->id(),
                ])
                ->action(function (array $data, WalletService $walletService) {
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
                }),
            Actions\CreateAction::make('dana_bos')
                ->label(__('Dana BOS'))
                ->color('success')
                ->icon('heroicon-o-building-library')
                ->fillForm(fn (): array => [
                    'from_wallet_id' => 'DANA_BOS',
                    'to_wallet_id' => 'YAYASAN',
                    'transaction_at' => now(),
                    'validated_by' => auth()->id(),
                ])
                ->action(function (array $data, WalletService $walletService) {
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
                })
        ];
    }
}
