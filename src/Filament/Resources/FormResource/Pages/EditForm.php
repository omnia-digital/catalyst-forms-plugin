<?php

namespace OmniaDigital\CatalystForms\Filament\Resources\FormResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystForms\Filament\Resources\FormResource;

class EditForm extends EditRecord
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make('delete'),
        ];
    }
}
