<?php

namespace App\Filament\Resources\StudentProductResource\Pages;

use App\Filament\Resources\StudentProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentProduct extends EditRecord
{
    protected static string $resource = StudentProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
