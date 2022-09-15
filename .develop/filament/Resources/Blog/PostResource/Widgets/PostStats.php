<?php

namespace App\Filament\Resources\Blog\PostResource\Widgets;

use App\Enums\PublishStatusEnum;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class PostStats extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total des articles', Post::count()),
            Card::make(
                'Mis en avant',
                Post::where('is_pinned', true)->count()
            ),
            Card::make('Publiés', Post::where('status', PublishStatusEnum::published)->count()),
        ];
    }
}
