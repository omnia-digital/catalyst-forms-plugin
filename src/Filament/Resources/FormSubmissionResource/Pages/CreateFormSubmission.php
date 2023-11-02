<?php

namespace OmniaDigital\CatalystForms\Filament\Resources\FormSubmissionResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use OmniaDigital\CatalystForms\Filament\Resources\FormSubmissionResource;

class CreateFormSubmission extends CreateRecord
{
    protected static string $resource = FormSubmissionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['data'] = json_decode($data['data']);

        return $data;
    }
}
