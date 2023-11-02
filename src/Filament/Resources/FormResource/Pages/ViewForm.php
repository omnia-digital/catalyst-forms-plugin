<?php

namespace OmniaDigital\CatalystFormsPlugin\Filament\Resources\FormResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use OmniaDigital\CatalystFormsPlugin\Filament\Resources\FormResource;

class ViewForm extends ViewRecord
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
