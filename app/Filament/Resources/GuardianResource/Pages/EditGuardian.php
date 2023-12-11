<?php

namespace App\Filament\Resources\GuardianResource\Pages;

use App\Filament\Resources\GuardianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuardian extends EditRecord
{
    protected static string $resource = GuardianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
