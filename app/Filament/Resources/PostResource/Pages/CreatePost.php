<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $data['author_id'] = auth()->id();

        $record = static::getModel()::create($data);
        return $record;
    }
}
