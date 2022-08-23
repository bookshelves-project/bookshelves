<?php

namespace App\Filament\Resources\Creation;

use App\Enums\ColorEnum;
use App\Enums\MediaTypeEnum;
use App\Filament\FormHelper;
use App\Filament\LayoutHelper;
use App\Filament\Resources\Creation\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?string $navigationGroup = 'Créations';

    protected static ?string $modelLabel = 'Prestations';

    public static function form(Form $form): Form
    {
        return LayoutHelper::columns($form, [
            self::formMainColumn(),
            self::formSideColumn(),
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
                BadgeColumn::make('sort')
                    ->label('Tri')
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
            ->defaultSort('sort', 'asc')
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

    public static function formMainColumn()
    {
        return LayoutHelper::mainColumn(
            [
                FormHelper::getTitle(),
                TextInput::make('sort')
                    ->label('Tri')
                    ->type('number'),
                TextInput::make('subtitle')
                    ->label('Sous-titre'),
                Select::make('color')
                    ->label('Couleur')
                    ->options(ColorEnum::toList())
                    ->default(ColorEnum::yellow),
                TextInput::make('title_after_purple_block')
                    ->label('Titre après le bloc mauve'),
                TextInput::make('cta_purple_block')
                    ->label('CTA du block mauve'),
                Textarea::make('hang')
                    ->label('Accroche')
                    ->columnSpan(2),
                Textarea::make('introduction')
                    ->label('Introduction')
                    ->helperText('Génère la description en SEO, uniquement à la création.')
                    ->reactive()
                    ->afterStateUpdated(FormHelper::updateOnlyOn('meta_description'))
                    ->columnSpan(2),
            ],
            [
                MarkdownEditor::make('body')
                    ->label('Contenu')
                    ->columnSpan(2),
            ],
            [
                Card::make()->schema([
                    Repeater::make('alternate_blocks')
                        ->label('Blocs en alternance')
                        ->schema([
                            TextInput::make('title')
                                ->label('Titre'),
                            FormHelper::getImageField(field: 'image', type: MediaTypeEnum::services),
                            MarkdownEditor::make('text')
                                ->label('Contenu')
                                ->columnSpan(2),
                        ])
                        ->collapsible()
                        ->collapsed()
                        ->maxItems(3)
                        ->columns(2)
                        ->columnSpan(2),
                ]),
                Card::make()->schema([
                    Placeholder::make('Accordéons')
                        ->columnSpan(2),
                    TextInput::make('accordion_title')
                        ->label('Titre')
                        ->columnSpan(2),
                    FormHelper::getImageField(field: 'accordion_image', type: MediaTypeEnum::services, label: 'Image')
                        ->columnSpan(2),
                    Repeater::make('accordion_blocks')
                        ->label('Blocs')
                        ->schema([
                            TextInput::make('title')
                                ->label('Titre'),
                            MarkdownEditor::make('text')
                                ->label('Contenu')
                                ->columnSpan(2),
                        ])
                        ->collapsible()
                        ->collapsed()
                        ->maxItems(3)
                        ->columns(2)
                        ->columnSpan(2),
                ]),
                Card::make()->schema([
                    Repeater::make('testimonies_blocks')
                        ->label('Témoignages')
                        ->schema([
                            TextInput::make('title')
                                ->label('Titre'),
                            FormHelper::getImageField(field: 'image', type: MediaTypeEnum::services),
                            TextInput::make('enterprise')
                                ->label('Entreprise'),
                            TextInput::make('name')
                                ->label('Nom de la personne'),
                        ])
                        ->collapsible()
                        ->collapsed()
                        ->maxItems(3)
                        ->columns(2)
                        ->columnSpan(2),
                ]),
            ]
        );
    }

    public static function formSideColumn()
    {
        return LayoutHelper::sideColumn(
            [
                FormHelper::getImageField(type: MediaTypeEnum::services, label: 'Image principale'),
                FormHelper::getImageField(field: 'image_extra', type: MediaTypeEnum::services, label: 'Image secondaire'),
                Textarea::make('cta')
                    ->label('CTA')
                    ->default('Vous souhaitez améliorer votre référencement naturel ? Confiez votre projet web à Useweb, agence spécialisée en SEO.'),
            ],
            [
                ...FormHelper::getSeo(Service::class),
            ],
        );
    }
}
