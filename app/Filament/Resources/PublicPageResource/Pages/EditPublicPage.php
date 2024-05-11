<?php

namespace App\Filament\Resources\PublicPageResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PublicPageResource;

class EditPublicPage extends EditRecord
{
    protected static string $resource = PublicPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, $data): Model
    {
        dd($data);
        $record->update($data);
        return $record;
    }
}
