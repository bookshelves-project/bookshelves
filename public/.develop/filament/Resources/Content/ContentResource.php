<?php

namespace App\Filament\Resources\Content;

use App\Enums\MediaTypeEnum;
use App\Filament\FormHelper;
use App\Filament\LayoutHelper;
use App\Filament\Resources\Content\ContentResource\Pages;
use App\Models\Content;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Str;

class ContentResource extends Resource
{
    protected static ?string $model = Content::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Contenus';

    protected static ?string $modelLabel = 'Contenu';

    public static function form(Form $form): Form
    {
        return LayoutHelper::columns($form, [
            LayoutHelper::mainColumn(
                [
                    TextInput::make('title')
                        ->label('Titre')
                        ->reactive()
                        ->afterStateUpdated(
                            fn ($state, callable $set) => $set('key', Str::slug($state))
                        ),
                    TextInput::make('key')
                        ->label('Clé')
                        ->required()
                        ->unique(Content::class, 'key', fn ($record) => $record)
                        ->hint('Unique pour ce contenu'),
                    MarkdownEditor::make('description')
                        ->label('Description')
                        ->columnSpan(2),
                ]
            ),
            LayoutHelper::sideColumn(
                [
                    FormHelper::getImageField(type: MediaTypeEnum::contents),
                    TextInput::make('hint')
                        ->label('Indication')
                        ->helperText('Optionnel, indiquer où ce contenu apparaitra pour le retrouver facilement.'),
                ]
            ),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->width(50)
                    ->height(50)
                    ->rounded(),
                TextColumn::make('key')
                    ->label('Clé'),
                TextColumn::make('title')
                    ->label('Titre'),
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
            'index' => Pages\ListContents::route('/'),
            'create' => Pages\CreateContent::route('/create'),
            'edit' => Pages\EditContent::route('/{record}/edit'),
        ];
    }
}
