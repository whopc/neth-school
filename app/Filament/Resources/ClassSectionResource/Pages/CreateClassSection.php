<?php

namespace App\Filament\Resources\SectionResource\Pages;

use App\Filament\Resources\ClassSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClassSection extends CreateRecord
{
    protected static string $resource = ClassSectionResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
