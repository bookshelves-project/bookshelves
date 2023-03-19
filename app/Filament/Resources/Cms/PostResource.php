<?php

namespace App\Filament\Resources\Cms;

use App\Enums\PostCategoryEnum;
use App\Filament\Resources\Cms\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Kiwilan\Steward\Enums\PublishStatusEnum;
use Kiwilan\Steward\Filament\Config\FilamentBuilder;
use Kiwilan\Steward\Filament\Config\FilamentBuilder\Modules\WordpressBuilder;
use Kiwilan\Steward\Filament\Config\FilamentForm;
use Kiwilan\Steward\Filament\Config\FilamentLayout;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $modelLabel = 'Post';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'CMS';

    public static function form(Form $form): Form
    {
        return FilamentLayout::make($form)
            ->schema([
                FilamentLayout::column([
                    [
                        Forms\Components\TextInput::make('title'),
                        Forms\Components\Select::make('category')
                            ->options(PostCategoryEnum::toArray())
                            ->default(PostCategoryEnum::ereader->value),
                        Forms\Components\Select::make('status')
                            ->options(PublishStatusEnum::toArray())
                            ->default(PublishStatusEnum::draft->value),
                        Forms\Components\DatePicker::make('published_at')
                            ->default(now()),
                        Forms\Components\Select::make('author')
                            ->relationship(
                                'author',
                                'name',
                                fn (Builder $query) => $query->whereHasBackEndAccess()
                            )
                            ->label('Author'),
                        Forms\Components\Textarea::make('summary')
                            ->columnSpan(2),
                    ],
                    [
                        FilamentBuilder::make(WordpressBuilder::class)->get(),
                    ],
                ]),
                FilamentLayout::column([
                    [
                        Forms\Components\FileUpload::make('picture'),
                        Forms\Components\Toggle::make('is_pinned')
                            ->label('Pinned'),
                    ],
                    [
                        FilamentForm::seo(),
                        FilamentForm::meta(),
                    ],
                ], 1),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('picture')
                    ->rounded()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->enum(PublishStatusEnum::toArray())
                    ->colors([
                        'primary',
                        'danger' => PublishStatusEnum::draft->value,
                        'warning' => PublishStatusEnum::scheduled->value,
                        'success' => PublishStatusEnum::published->value,
                    ])
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('category')
                    ->enum(PostCategoryEnum::toArray())
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\BadgeColumn::make('author.name')
                //     ->sortable()
                //     ->searchable(),
                Tables\Columns\IconColumn::make('is_pinned')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->date('Y-m-d')
                    ->sortable(),
            ])
            ->filters([
                FilamentForm::dateFilter('published_at'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
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
}
