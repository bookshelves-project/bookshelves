<?php

namespace App\Filament\Resources;

use App\Enums\LibraryTypeEnum;
use App\Filament\Resources\LibraryResource\Pages;
use App\Models\Library;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Kiwilan\Steward\Filament\Components\MetaBlock;
use Kiwilan\Steward\Filament\Components\NameInput;
use Kiwilan\Steward\Filament\Config\FilamentLayout;

class LibraryResource extends Resource
{
    protected static ?string $model = Library::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return FilamentLayout::make($form)
            ->schema([
                FilamentLayout::column([
                    FilamentLayout::section([
                        NameInput::make('name')
                            ->autofocus()
                            ->required()
                            ->placeholder('Enter library name'),
                        Components\Select::make('type')
                            ->required()
                            ->options(LibraryTypeEnum::toLabels())
                            ->default(LibraryTypeEnum::book),
                        Components\TextInput::make('path')
                            ->required()
                            ->columnSpan(2)
                            ->placeholder('Enter absolute path of library'),
                    ]),
                ]),
                FilamentLayout::column([
                    FilamentLayout::section([
                        Components\TextInput::make('slug')
                            ->unique(ignoreRecord: true)
                            ->helperText('Used for URL'),
                        Components\Toggle::make('is_enabled')
                            ->default(true)
                            ->label('Enabled')
                            ->helperText('Enable or disable this library'),
                        Components\Toggle::make('path_is_valid')
                            ->disabled()
                            ->label('Path is valid')
                            ->helperText('Check if path is valid (automatic)'),
                        MetaBlock::make(),
                    ]),
                ], width: 1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('path')
                    ->badge(),
                Tables\Columns\TextColumn::make('books_count')->counts('books'),
                Tables\Columns\ToggleColumn::make('is_enabled')
                    ->label('Enabled'),
                Tables\Columns\IconColumn::make('path_is_valid')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort')
            ->reorderable('sort');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibraries::route('/'),
            'create' => Pages\CreateLibrary::route('/create'),
            'edit' => Pages\EditLibrary::route('/{record}/edit'),
        ];
    }
}
