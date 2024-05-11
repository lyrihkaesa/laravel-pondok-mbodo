<?php

namespace App\Filament\Resources\PublicPageResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PublicPageResource;

class CreatePublicPage extends CreateRecord
{
    protected static string $resource = PublicPageResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // dd($data);
        return static::getModel()::create($data);
    }
}
