<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\BookResource;
use App\Models\Book;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBooks extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(BookResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('library.name')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('serie.title')
                    ->searchable()
                    ->sortable()
                    ->suffix(fn (Book $record) => $record->volume_pad ? ' #'.$record->volume_pad : ''),
                Tables\Columns\TextColumn::make('authors.name')
                    ->limit(50)
                    ->tooltip(fn (Book $record) => $record->authors->pluck('name')->join(', '))
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('format')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('added_at')
                    ->dateTime('Y/m/d')
                    ->searchable()
                    ->sortable(),
            ])
            ->actions([
                //
            ]);
    }
}
