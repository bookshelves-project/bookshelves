<?php

namespace App\Filament\Resources\Creation\TeamMemberResource\Pages;

use App\Filament\Resources\Creation\TeamMemberResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeamMembers extends ListRecords
{
    protected static string $resource = TeamMemberResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
