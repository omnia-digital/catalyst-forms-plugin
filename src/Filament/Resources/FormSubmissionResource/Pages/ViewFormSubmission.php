<?php

namespace OmniaDigital\CatalystForms\Filament\Resources\FormSubmissionResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use OmniaDigital\CatalystForms\Filament\Resources\FormSubmissionResource;

class ViewFormSubmission extends ViewRecord
{
    protected static string $resource = FormSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\EditAction::make(),
        ];
    }
}
