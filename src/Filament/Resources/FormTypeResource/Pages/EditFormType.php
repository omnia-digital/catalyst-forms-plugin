<?php

namespace OmniaDigital\CatalystForms\Filament\Resources\FormTypeResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystForms\Filament\Resources\FormTypeResource;

class EditFormType extends EditRecord
{
    protected static string $resource = FormTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make('delete'),
        ];
    }
}
