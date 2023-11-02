<?php

namespace OmniaDigital\CatalystForms\Filament\Resources\FormTypeResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use OmniaDigital\CatalystForms\Filament\Resources\FormTypeResource;

class ViewFormType extends ViewRecord
{
    protected static string $resource = FormTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\EditAction::make(),
        ];
    }
}
