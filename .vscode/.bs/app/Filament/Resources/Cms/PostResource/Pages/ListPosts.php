<?php

namespace App\Filament\Resources\Cms\PostResource\Pages;

use App\Filament\Resources\Cms\PostResource;
use App\Models\Post;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Kiwilan\Steward\Filament\Actions\PublishableActions;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            ...PublishableActions::make('posts', Post::class),
            Actions\CreateAction::make(),
        ];
    }
}
