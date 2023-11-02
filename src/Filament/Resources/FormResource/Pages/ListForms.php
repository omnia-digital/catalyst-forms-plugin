<?php

namespace OmniaDigital\CatalystForms\Filament\Resources\FormResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use OmniaDigital\CatalystForms\Filament\Resources\FormResource;

class ListForms extends ListRecords
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
