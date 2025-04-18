<?php

namespace App\Filament\Resources\SectionResource\Pages;

use App\Filament\Resources\ClassSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassSections extends ListRecords
{
    protected static string $resource = ClassSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('fas-puzzle-piece')->label('Crear Sección'),
        ];
    }
}
