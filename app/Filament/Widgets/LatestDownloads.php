<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\DownloadResource;
use App\Models\Download;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestDownloads extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return DownloadResource::table($table)
            ->query(DownloadResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('Y/m/d H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip')
                    ->label('IP')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->limit(50)
                    ->tooltip(fn (Download $record) => $record->name)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('authors')
                    ->limit(50)
                    ->tooltip(fn (Download $record) => $record->authors)
                    ->searchable(),
                Tables\Columns\TextColumn::make('format')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_series')
                    ->label('Series')
                    ->boolean()
                    ->sortable()
                    ->trueColor('info')
                    ->falseColor('warning'),
                Tables\Columns\TextColumn::make('library.name')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->searchable()
                    ->sortable(),
            ])
            ->actions([
                //
            ]);
    }
}
