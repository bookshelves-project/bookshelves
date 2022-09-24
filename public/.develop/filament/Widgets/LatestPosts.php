<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Blog\PostResource;
use App\Models\Post;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Kiwilan\Steward\Enums\PublishStatusEnum;

class LatestPosts extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected static ?string $heading = 'Derniers articles publiés';

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 5;
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'published_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableQuery(): Builder
    {
        return PostResource::getEloquentQuery()->where('status', PublishStatusEnum::published->value);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('published_at')
                ->label('Publié le')
                ->date('Y/m/d')
                ->sortable(),
            Tables\Columns\TextColumn::make('title')
                ->label('Titre')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('authors.full_name')
                ->label('Auteur·ices')
                ->searchable()
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('open')
                ->url(fn (Post $record): string => PostResource::getUrl('edit', ['record' => $record])),
        ];
    }
}
