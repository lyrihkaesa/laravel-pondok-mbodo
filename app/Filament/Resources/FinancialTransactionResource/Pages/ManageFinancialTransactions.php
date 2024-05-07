<?php

namespace App\Filament\Resources\FinancialTransactionResource\Pages;

use App\Models\FinancialTransaction;
use Filament\Actions;
use App\Services\WalletService;
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
                })
        ];
    }
}
