<?php

namespace App\Filament\RelationManagers;

use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    protected static ?string $recordTitleAttribute = 'title';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ])
        ;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover_filament')
                    ->collection('cover')
                    ->label('Cover')
                    ->circular(),
                Tables\Columns\TextColumn::make('volume'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('authors.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('show')
                    ->url(fn (Book $record): string => route('filament.resources.books.edit', ['record' => $record->id]))
                    ->icon('heroicon-o-pencil'),
            ])
            ->defaultSort('volume')
        ;
    }
}