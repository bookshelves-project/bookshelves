<?php

namespace App\Filament\Resources;

use App\Enums\BookTypeEnum;
use App\Facades\Bookshelves;
use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Kiwilan\Steward\Filament\Config\FilamentLayout;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return FilamentLayout::make($form)
            ->schema([
                FilamentLayout::column([
                    FilamentLayout::section([
                        Components\TextInput::make('title')
                            ->required(),
                        // Components\TextInput::make('email')
                        //     ->required()
                        //     ->email()
                        //     ->placeholder('Enter your email'),
                        // Components\Select::make('role')
                        //     ->options(UserRoleEnum::toArray())
                        //     ->default(UserRoleEnum::user),
                        // Components\DatePicker::make('email_verified_at')
                        //     ->format('d/m/Y'),
                    ]),
                ]),
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
                    ->tooltip(fn (Book $record) => $record->authors->pluck('name')->join(', '))
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('serie.title')
                    ->suffix(fn (Book $record) => " #{$record->volume_pad}")
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('format')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('released_on')
                    ->dateTime('d/m/Y')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('isbn')
                    ->badge()
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('language.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('publisher.name')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->multiple()
                    ->options(BookTypeEnum::getLabels()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('slug');
    }

    public static function getRelations(): array
    {
        return [
            //
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
}
