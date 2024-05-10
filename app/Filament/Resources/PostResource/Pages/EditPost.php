<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, $data): Model
    {
        $record->update($data);

        return $record;
    }
}
