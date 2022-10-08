<?php

namespace App\Filament\Resources\Books;

use App\Enums\BookTypeEnum;
use App\Filament\FormHelper;
use App\Filament\LayoutHelper;
use App\Filament\RelationManagers\BooksRelationManager;
use App\Filament\Resources\Books\SerieResource\Pages;
use App\Models\Serie;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class SerieResource extends Resource
{
    use Translatable;

    protected static ?string $model = Serie::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Books';

    public static function form(Form $form): Form
    {
        return LayoutHelper::columns($form, [
            LayoutHelper::mainColumn(
                [
                    Forms\Components\TextInput::make('title')
                        ->label('Title'),
                    Forms\Components\Select::make('language')
                        ->relationship('language', 'name')
                        ->label('Language'),
                    Forms\Components\MultiSelect::make('authors')
                        ->relationship('authors', 'name')
                        ->label('Authors')
                        ->columnSpan(2),
                ],
                [
                    Forms\Components\SpatieTagsInput::make('tags')
                        ->type('tag')
                        ->label('Tags')
                        ->columnSpan(2),
                    Forms\Components\SpatieTagsInput::make('tags_genre')
                        ->type('genre')
                        ->label('Genre')
                        ->columnSpan(2),
                ],
                [
                    Forms\Components\RichEditor::make('description')
                        ->label('Description')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('link')
                        ->label('Link')
                        ->columnSpan(2),
                ]
            ),
            LayoutHelper::sideColumn(
                [
                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                        ->collection('cover')
                        ->label('Cover'),
                    Forms\Components\TextInput::make('slug')
                        ->label('Metalink'),
                    Forms\Components\TextInput::make('slug_sort')
                        ->label('Sort by')
                        ->disabled(),
                    Forms\Components\Select::make('type')
                        ->label('Type')
                        ->options(BookTypeEnum::toList())
                        ->default(BookTypeEnum::novel->value),
                    ...FormHelper::getTimestamps(),
                ]
            ),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('cover')
                    ->label('Cover')
                    ->rounded(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug_sort')
                    ->label('Sort by')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Type')
                    ->colors([
                        'primary',
                        'danger' => BookTypeEnum::audio,
                        'success' => BookTypeEnum::comic,
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Authors')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('language.name')
                    ->label('Language')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('books_count')
                    ->counts('books')
                    ->label('Books')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('slug_sort')
        ;
    }

    public static function getRelations(): array
    {
        return [
            BooksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeries::route('/'),
            'create' => Pages\CreateSerie::route('/create'),
            'edit' => Pages\EditSerie::route('/{record}/edit'),
        ];
    }

    public static function getTranslatableLocales(): array
    {
        return ['en', 'fr'];
    }
}
