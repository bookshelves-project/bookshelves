<?php

namespace App\Filament\Resources\Content;

use App\Enums\MediaTypeEnum;
use App\Filament\FormHelper;
use App\Filament\LayoutHelper;
use App\Filament\Resources\Content\PageResource\Pages;
use App\Models\Page;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-add';

    protected static ?string $navigationGroup = 'Contenus';

    protected static ?string $modelLabel = 'Page';

    public static function form(Form $form): Form
    {
        return LayoutHelper::columns($form, [
            LayoutHelper::mainColumn(
                [
                    FormHelper::getTitle(),
                    Textarea::make('summary')
                        ->label('Résumé')
                        ->helperText('Génère la description en SEO, uniquement à la création.')
                        ->reactive()
                        ->afterStateUpdated(FormHelper::updateOnlyOn('meta_description'))
                        ->columnSpan(2),

                ],
                [
                    MarkdownEditor::make('body')
                        ->label('Contenu')
                        ->columnSpan(2),
                ]
            ),
            LayoutHelper::sideColumn(
                [
                    FormHelper::getImageField(type: MediaTypeEnum::pages),
                ],
                [
                    ...FormHelper::getSeo(Page::class),
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
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                FormHelper::showAction(),
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
