<?php

namespace App\Filament\Resources;

use App\Enums\BookTypeEnum;
use App\Facades\Bookshelves;
use App\Filament\Resources\SerieResource\Pages;
use App\Models\Serie;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SerieResource extends Resource
{
    protected static ?string $model = Serie::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Books';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Serie $record */
        return [
            'Books' => "{$record->books_count}",
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('cover')
                    ->collection(Bookshelves::imageCollection())
                    ->conversion('thumbnail')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('authors.name')
                    ->limit(50)
                    ->tooltip(fn (Serie $record) => $record->authors->pluck('name')->join(', '))
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('books_count')
                    ->label('Books')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('library.name')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('language.name')
                    ->searchable(),
            ])
            ->filters([
                // SelectFilter::make('type')
                //     ->multiple()
                //     ->options(BookTypeEnum::getLabels()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount(['books']);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeries::route('/'),
            'create' => Pages\CreateSerie::route('/create'),
            'edit' => Pages\EditSerie::route('/{record}/edit'),
        ];
    }
}
