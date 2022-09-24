<?php

namespace App\Filament\Resources\Settings\SubmissionResource\Pages;

use App\Filament\Resources\Settings\SubmissionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubmission extends EditRecord
{
    protected static string $resource = SubmissionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
