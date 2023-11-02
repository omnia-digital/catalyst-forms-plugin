<?php

namespace OmniaDigital\CatalystFormsPlugin\Filament\Resources\FormSubmissionResource\Pages;

use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystFormsPlugin\Filament\Resources\FormSubmissionResource;

class EditFormSubmission extends EditRecord
{
    protected static string $resource = FormSubmissionResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['data'] = json_decode($data['data']);

        return $data;
    }
}
