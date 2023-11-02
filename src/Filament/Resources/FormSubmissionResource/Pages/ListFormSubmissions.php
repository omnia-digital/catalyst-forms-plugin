<?php

namespace OmniaDigital\CatalystFormsPlugin\Filament\Resources\FormSubmissionResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use OmniaDigital\CatalystFormsPlugin\Filament\Resources\FormSubmissionResource;

class ListFormSubmissions extends ListRecords
{
    protected static string $resource = FormSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
