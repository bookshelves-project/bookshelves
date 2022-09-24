<?php

namespace App\Filament\Resources\Blog;

use App\Enums\MediaTypeEnum;
use App\Enums\PostTypeEnum;
use App\Filament\FormHelper;
use App\Filament\LayoutHelper;
use App\Filament\Resources\Blog\PostResource\Pages;
use App\Filament\Resources\Blog\PostResource\Widgets\PostStats;
use App\Filament\Resources\Blog\TagResource\RelationManagers\PostsRelationManager;
use App\Models\Post as ModelsPost;
use App\Models\Tag;
use App\Models\TeamMember;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Kiwilan\Steward\Enums\PublishStatusEnum;

class PostResource extends Resource
{
    protected static ?string $model = ModelsPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?string $modelLabel = 'Article';

    public static function form(Form $form): Form
    {
        return LayoutHelper::columns($form, [
            LayoutHelper::mainColumn(
                [
                    FormHelper::getTitle(),
                    TextInput::make('subtitle')
                        ->label('Sous-titre'),
                    TextInput::make('youtube_id')
                        ->label('Lien YouTube')
                        ->helperText("Indiquez l'identifiant de la vidéo, example : `3u_vIdnJYLc` pour la vidéo `https://www.youtube.com/watch?v=3u_vIdnJYLc`.")
                        ->columnSpan(2),
                    MultiSelect::make('tags')
                        ->relationship('tags', 'name')
                        ->getOptionLabelFromRecordUsing(fn (Tag $record) => $record->name)
                        ->columnSpan(2),
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
                    FormHelper::getImageField(type: MediaTypeEnum::posts),
                    Toggle::make('is_pinned')
                        ->label('Mis en avant')
                        ->helperText("Afficher en page d'accueil.")
                        ->default(false),
                    Select::make('status')
                        ->label('Statut')
                        ->options(PublishStatusEnum::toList())
                        ->default(PublishStatusEnum::draft->value),
                    Select::make('type')
                        ->label('Type')
                        ->options(PostTypeEnum::toList())
                        ->default(PostTypeEnum::seo->value),
                    DatePicker::make('published_at')
                        ->label('Publié le')
                        ->default(now())
                        ->required(),
                    Textarea::make('cta')
                        ->label('CTA')
                        ->default('Vous souhaitez améliorer votre référencement naturel ? Confiez votre projet web à Useweb, agence spécialisée en SEO.'),
                    MultiSelect::make('authors')
                        ->label('Auteur·ices')
                        ->relationship('authors', 'firstname')
                        ->getOptionLabelFromRecordUsing(fn (TeamMember $record) => "{$record->firstname} {$record->lastname}"),
                ],
                [
                    ...FormHelper::getSeo(ModelsPost::class),
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
                TextColumn::make('published_at')
                    ->label('Date de publication')
                    ->date('d/m/Y')
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'danger' => PublishStatusEnum::draft->value,
                        'warning' => PublishStatusEnum::scheduled->value,
                        'success' => PublishStatusEnum::published->value,
                    ])
                    ->sortable(),
                BadgeColumn::make('type')
                    ->label('Type')
                    ->colors([
                        'success' => PostTypeEnum::seo->value,
                        'primary' => PostTypeEnum::development->value,
                    ])
                    ->sortable(),
                BooleanColumn::make('is_pinned')
                    ->label('Mis en avant')
                    ->sortable(),
            ])
            ->filters([
                FormHelper::getDateFilter('published_at'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                FormHelper::showAction(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('published_at', 'desc')
        ;
    }

    public static function getRelations(): array
    {
        return [
            // PostsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            PostStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return strval(
            ModelsPost::where('status', '!=', PublishStatusEnum::published)
                ->count()
        );
    }
}
