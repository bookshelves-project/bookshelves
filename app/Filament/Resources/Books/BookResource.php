<?php

namespace App\Filament\Resources\Books;

use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use App\Filament\FormHelper;
use App\Filament\LayoutHelper;
use App\Filament\RelationManagers\GoogleBookRelationManager;
use App\Filament\Resources\Books\BookResource\Pages;
use App\Forms\Components\SpatieMediaView;
use App\Models\Book;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 1;

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
                    Forms\Components\Select::make('serie')
                        ->relationship('serie', 'title')
                        ->label('Serie'),
                    Forms\Components\TextInput::make('volume')
                        ->type('number')
                        ->label('Volume'),
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
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'redo',
                            'strike',
                            'undo',
                        ])
                        ->label('Description')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('isbn10')
                        ->label('ISBN 10'),
                    Forms\Components\TextInput::make('isbn13')
                        ->helperText('ISBN 13 will be show instead of ISBN 10 if exists.')
                        ->label('ISBN 13'),
                    Forms\Components\KeyValue::make('identifiers')
                        ->keyPlaceholder('Name')
                        ->valuePlaceholder('Value')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('contributor')
                        ->label('Contributor'),
                    Forms\Components\TextInput::make('rights')
                        ->label('Rights'),
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
                    Forms\Components\Toggle::make('is_disabled')
                        ->label('Disabled')
                        ->helperText('Prevent this book from being displayed in the public catalog.'),
                ],
                [
                    Forms\Components\Select::make('publisher')
                        ->relationship('publisher', 'name'),
                    Forms\Components\DatePicker::make('released_on')
                        ->label('Released on'),
                    Forms\Components\TextInput::make('page_count')
                        ->type('number')
                        ->label('Page count'),
                    Forms\Components\TextInput::make('maturity_rating')
                        ->label('Rating'),
                    ...FormHelper::getTimestamps(),
                ],
                [
                    Forms\Components\SpatieMediaLibraryFileUpload::make(BookFormatEnum::epub->value)
                        ->collection(BookFormatEnum::epub->value)
                        ->label('EPUB'),
                    // SpatieMediaView::make(BookFormatEnum::epub->value)
                    //     ->path('formats')
                    //     ->type(BookFormatEnum::epub->value)
                    //     ->label(''),
                    Forms\Components\SpatieMediaLibraryFileUpload::make(BookFormatEnum::cbr->value)
                        ->collection(BookFormatEnum::cbr->value)
                        ->directory('formats')
                        ->label('CBR'),
                    Forms\Components\SpatieMediaLibraryFileUpload::make(BookFormatEnum::cbz->value)
                        ->collection(BookFormatEnum::cbz->value)
                        ->label('CBZ'),
                    Forms\Components\SpatieMediaLibraryFileUpload::make(BookFormatEnum::pdf->value)
                        ->collection(BookFormatEnum::pdf->value)
                        ->label('PDF'),
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
                Tables\Columns\TextColumn::make('serie.title')
                    ->label('Serie')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('volume')
                    ->label('Volume')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\SpatieTagsColumn::make('tags')
                    ->type('genre')
                    ->label('Genre')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\BooleanColumn::make('is_disabled')
                    ->label('Disabled')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('publisher.name')
                    ->label('Publisher')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('released_on')
                    ->label('Released on')
                    ->date('Y-m-d')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                FormHelper::getDateFilter('released_on'),
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options(BookTypeEnum::toList()),
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
            GoogleBookRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(mixed $record): string
    {
        $volume = $record->volume ? "vol. {$record->volume}" : '';
        $serie = $record->serie ? " in {$record->serie->title} {$volume}" : '';

        return "{$record->title}{$serie}";
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'authors.name', 'serie.title'];
    }

    protected static function getNavigationBadge(): ?string
    {
        $count = Book::whereIsDisabled(true)->count();
        return "{$count}";
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Tables\Filters\Layout::AboveContent;
    }

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }
}
