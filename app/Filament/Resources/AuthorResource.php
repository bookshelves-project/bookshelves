<?php

namespace App\Filament\Resources;

use App\Enums\AuthorRoleEnum;
use App\Filament\LayoutHelper;
use App\Filament\RelationManagers\BooksRelationManager;
use App\Filament\RelationManagers\ReviewsRelationManager;
use App\Filament\RelationManagers\SeriesRelationManager;
use App\Filament\RelationManagers\WikipediaItemRelationManager;
use App\Filament\Resources\AuthorResource\Pages;
use App\Models\Author;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Books';

    public static function form(Form $form): Form
    {
        return LayoutHelper::columns($form, [
            LayoutHelper::mainColumn(
                [
                    Forms\Components\TextInput::make('lastname')
                        ->label('Lastname'),
                    Forms\Components\TextInput::make('firstname')
                        ->label('Firstname'),
                    Forms\Components\TextInput::make('name')
                        ->disabled()
                        ->label('Name'),
                ],
                [
                    Forms\Components\TextInput::make('link')
                        ->label('Link')
                        ->columnSpan(2),
                    Forms\Components\Textarea::make('note')
                        ->label('Note')
                        ->columnSpan(2),
                ]
            ),
            LayoutHelper::sideColumn(
                [
                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                        ->collection('cover')
                        ->label('Cover'),
                    Forms\Components\Select::make('role')
                        ->label('Role')
                        ->options(AuthorRoleEnum::toList())
                        ->default(AuthorRoleEnum::aut->value),
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
                Tables\Columns\TextColumn::make('lastname')
                    ->label('Lastname')
                    ->sortable(),
                Tables\Columns\TextColumn::make('firstname')
                    ->label('Firstname')
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Metalink')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('books_count')
                    ->counts('books')
                    ->label('Books')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('series_count')
                    ->counts('series')
                    ->label('Series')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviews_count')
                    ->counts('reviews')
                    ->label('Reviews')
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
            ->defaultSort('slug')
        ;
    }

    public static function getRelations(): array
    {
        return [
            BooksRelationManager::class,
            SeriesRelationManager::class,
            ReviewsRelationManager::class,
            WikipediaItemRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
