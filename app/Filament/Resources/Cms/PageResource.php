<?php

namespace App\Filament\Resources\Cms;

use App\Filament\LayoutHelper;
use App\Filament\Resources\Cms\PageResource\Pages;
use App\Models\Cms\Page;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        // return LayoutHelper::columns($form, [
        //     LayoutHelper::mainColumn(
        //         [
        //             Forms\Components\TextInput::make('title')
        //                 ->label('Title'),
        //         ]
        //     ),
        //     LayoutHelper::sideColumn(
        //         []
        //     )
        // ]);

        return LayoutHelper::columns($form, [
            LayoutHelper::mainColumn(
                [
                    Forms\Components\TextInput::make('title')
                        ->label('Title'),
                    LayoutHelper::card('Hero', [
                        Forms\Components\TextInput::make('title')
                            ->label('Title'),
                        Forms\Components\Textarea::make('text')
                            ->label('Text')
                            ->columnSpan(2),
                        Forms\Components\SpatieMediaLibraryFileUpload::make('media')
                            ->label('Media'),
                    ]),
                    LayoutHelper::card('Statistics', [
                        Forms\Components\TextInput::make('eyebrow')
                            ->label('Eyebrow'),
                        Forms\Components\TextInput::make('title')
                            ->label('Title'),
                        Forms\Components\KeyValue::make('list')
                            ->label('List')
                            ->keyLabel('Label')
                            ->valueLabel('Query')
                            ->columnSpan(2),
                    ]),
                    LayoutHelper::card('Logos', [
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->columnSpan(2),
                        Forms\Components\Repeater::make('list')
                            ->schema([
                                Forms\Components\TextInput::make('label'),
                                Forms\Components\TextInput::make('slug'),
                                Forms\Components\TextInput::make('link')
                                    ->url(),
                                Forms\Components\SpatieMediaLibraryFileUpload::make('media'),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->columns(2)
                            ->columnSpan(2),
                    ]),
                ]
            ),
            LayoutHelper::sideColumn(
                []
            ),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
        ;
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
