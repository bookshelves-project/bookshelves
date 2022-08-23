<?php

namespace App\Filament\Widgets;

use App\Filament\ChartHelper;
use App\Models\Post;
use App\Models\Reference;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getCards(): array
    {
        $posts = ChartHelper::chartBy('posts', 'published_at', published: true);
        $references = ChartHelper::chartByField('references', 'presentation_year');
        $services = ChartHelper::chartBy('services', 'created_at');
        // dump($services);

        return [
            Card::make('Articles publiés', Post::published()->count())
                ->description('Vos articles')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($posts->stats)
                ->color('success'),
            Card::make('Réalisations publiées', Reference::published()->count())
                ->description('Toutes vos réalisations')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($references->stats)
                ->color('success'),
            Card::make('Prestations', Service::count())
                ->description('Vos prestations')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($services->stats)
                ->color('success'),
        ];
    }
}
