<?php

namespace App\Filament\Resources\LawResource\Pages;

use App\Filament\Resources\LawResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaw extends EditRecord
{
    protected static string $resource = LawResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
