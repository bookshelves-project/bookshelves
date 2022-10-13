<?php

namespace App\Filament\Resources\Cms;

use App\Enums\PostCategoryEnum;
use App\Filament\Resources\Cms\PostResource\Pages;
use App\Models\Post;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Kiwilan\Steward\Enums\PublishStatusEnum;
use Kiwilan\Steward\Filament\FormConfig;
use Kiwilan\Steward\Filament\StwFormConfig;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $modelLabel = 'Post';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'CMS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                Tables\Columns\BadgeColumn::make('author.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_pinned')
                ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                StwFormConfig::getDateFilter('published_at'),
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
