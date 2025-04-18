<?php

namespace App\Filament\Resources\SectionResource\Pages;

use App\Filament\Resources\ClassSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassSection extends EditRecord
{
    protected static string $resource = ClassSectionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
