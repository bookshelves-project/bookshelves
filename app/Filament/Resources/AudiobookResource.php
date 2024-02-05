<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AudiobookResource\Pages;
use App\Models\Audiobook;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AudiobookResource extends Resource
{
    protected static ?string $model = Audiobook::class;

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';

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
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('serie')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('narrators')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('authors')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('volume')
                    ->sortable(),
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
            ]);
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
            'index' => Pages\ListAudiobooks::route('/'),
            'create' => Pages\CreateAudiobook::route('/create'),
            'edit' => Pages\EditAudiobook::route('/{record}/edit'),
        ];
    }
}
