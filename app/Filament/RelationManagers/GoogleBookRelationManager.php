<?php

namespace App\Filament\RelationManagers;

use App\Models\GoogleBook;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class GoogleBookRelationManager extends RelationManager
{
    protected static string $relationship = 'googleBook';

    protected static ?string $recordTitleAttribute = 'isbn13';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('isbn13')
                            ->label('ISBN 13'),
                        Forms\Components\TextInput::make('isbn10')
                            ->label('ISBN 10'),
                        Forms\Components\TextInput::make('original_isbn')
                            ->label('Original ISBN'),
                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->required()
                            ->url()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('preview_link')
                            ->url()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('buy_link')
                            ->url()
                            ->columnSpan(2),
                        Forms\Components\DatePicker::make('published_date'),
                        Forms\Components\MarkdownEditor::make('description')
                            ->columnSpan(2),
                        Forms\Components\KeyValue::make('industry_identifiers')
                            ->keyPlaceholder('Name')
                            ->valuePlaceholder('Value')
                            ->columnSpan(2),
                        Forms\Components\KeyValue::make('categories')
                            ->keyPlaceholder('Name')
                            ->valuePlaceholder('Value')
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('page_count')
                            ->type('number'),
                        Forms\Components\TextInput::make('maturity_rating'),
                        Forms\Components\TextInput::make('language'),
                        Forms\Components\TextInput::make('publisher'),
                        Forms\Components\TextInput::make('retail_price_amount'),
                        Forms\Components\TextInput::make('retail_price_currency_code'),
                    ])
                    ->columns([
                        'sm' => 2,
                    ]),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('isbn13')
                    ->label('ISBN 13'),
                Tables\Columns\TextColumn::make('isbn10')
                    ->label('ISBN 10'),
                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->url(fn (GoogleBook $record): string => $record->url)
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ])
        ;
    }
}
