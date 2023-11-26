<?php

namespace App\Filament\Resources\StudentProductResource\Pages;

use App\Filament\Resources\StudentProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentProduct extends CreateRecord
{
    protected static string $resource = StudentProductResource::class;
}
