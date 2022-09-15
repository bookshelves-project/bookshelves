<?php

namespace App\Filament\Resources\Creation;

use App\Enums\MediaTypeEnum;
use App\Enums\PublishStatusEnum;
use App\Filament\FormHelper;
use App\Filament\LayoutHelper;
use App\Filament\Resources\Creation\ReferenceResource\Pages;
use App\Filament\Resources\Creation\ReferenceResource\Widgets\ReferenceStats;
use App\Models\Reference;
use App\Models\ReferenceCategory;
use App\Models\Service;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\MultiSelect;
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

class ReferenceResource extends Resource
{
    protected static ?string $model = Reference::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Créations';

    protected static ?string $modelLabel = 'Réalisation';

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
                TextColumn::make('presentation_year')
                    ->label('Année de création')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Date de publication')
                    ->date('d/m/Y')
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'primary',
                        'danger' => PublishStatusEnum::draft->value,
                        'warning' => PublishStatusEnum::scheduled->value,
                        'success' => PublishStatusEnum::published->value,
                    ])
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
            ->defaultSort('presentation_year', 'desc')
        ;
    }

    public static function getWidgets(): array
    {
        return [
            ReferenceStats::class,
        ];
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
            'index' => Pages\ListReferences::route('/'),
            'create' => Pages\CreateReference::route('/create'),
            'edit' => Pages\EditReference::route('/{record}/edit'),
        ];
    }

    public static function formMainColumn()
    {
        return LayoutHelper::mainColumn(
            [
                FormHelper::getTitle(),
                TextInput::make('site_url')
                    ->label('Site web')
                    ->url(),
                Textarea::make('summary')
                    ->label('Résumé')
                    ->helperText('Génère la description en SEO, uniquement à la création.')
                    ->reactive()
                    ->afterStateUpdated(FormHelper::updateOnlyOn('meta_description'))
                    ->columnSpan(2),
                Select::make('reference_category_id')
                    ->label('Catégorie')
                    ->relationship('category', 'name')
                    ->getOptionLabelFromRecordUsing(fn (ReferenceCategory $record) => $record->name),
                MultiSelect::make('services')
                    ->label('Prestations liées')
                    ->relationship('services', 'title')
                    ->getOptionLabelFromRecordUsing(fn (Service $record) => $record->title)
                    ->columnSpan(2),
            ],
            [
                Card::make()->schema([
                    Placeholder::make('Présentation')
                        ->columnSpan(2),
                    TextInput::make('presentation_title')
                        ->label('Titre'),
                    TextInput::make('presentation_year')
                        ->type('number')
                        ->label('Année'),
                    MarkdownEditor::make('presentation_text')
                        ->label('Contenu')
                        ->columnSpan(2),
                ]),
                Card::make()->schema([
                    Placeholder::make('Témoignage')
                        ->columnSpan(2),
                    TextInput::make('testimony_title')
                        ->label('Titre'),
                    FormHelper::getImageField(field: 'testimony_image', type: MediaTypeEnum::references),
                    MarkdownEditor::make('testimony_text')
                        ->label('Contenu')
                        ->columnSpan(2),
                ]),
            ],
            [
                Repeater::make('alternate_blocks')
                    ->label('Blocs en alternance')
                    ->schema([
                        TextInput::make('title')
                            ->label('Titre'),
                        FormHelper::getImageField(field: 'image', type: MediaTypeEnum::references),
                        MarkdownEditor::make('text')
                            ->label('Contenu')
                            ->columnSpan(2),
                    ])
                    ->collapsible()
                    ->maxItems(3)
                    ->columns(2)
                    ->columnSpan(2),
            ]
        );
    }

    public static function formSideColumn()
    {
        return LayoutHelper::sideColumn(
            [
                FormHelper::getImageField(label: 'Image de présentation', type: MediaTypeEnum::references),
                Select::make('status')
                    ->label('Statut')
                    ->options(PublishStatusEnum::toList())
                    ->default(PublishStatusEnum::draft->value),
                DatePicker::make('published_at')
                    ->label('Publié le')
                    ->default(now()),
                Textarea::make('cta')
                    ->label('CTA')
                    ->default('Vous souhaitez améliorer votre référencement naturel ? Confiez votre projet web à Useweb, agence spécialisée en SEO.'),
            ],
            [
                ...FormHelper::getSeo(Reference::class),
            ],
        );
    }

    protected static function getNavigationBadge(): ?string
    {
        return strval(
            Reference::where('status', '!=', PublishStatusEnum::published)
                ->count()
        );
    }
}
