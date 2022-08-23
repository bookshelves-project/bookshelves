<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Settings\SubmissionResource;
use App\Models\Submission;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestSubmissions extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 0;

    protected static ?string $heading = 'Derniers messages reçus';

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 5;
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableQuery(): Builder
    {
        return SubmissionResource::getEloquentQuery();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->label('Réception')
                ->date('Y/m/d')
                ->sortable(),
            Tables\Columns\TextColumn::make('subject')
                ->label('Sujet')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('name')
                ->label('Nom')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('open')
                ->url(fn (Submission $record): string => SubmissionResource::getUrl('edit', ['record' => $record])),
        ];
    }
}
