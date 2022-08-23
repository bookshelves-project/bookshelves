<?php

namespace App\Filament\Resources\Blog;

use App\Filament\LayoutHelper;
use App\Filament\Resources\Blog\TagResource\Pages;
use App\Models\Tag as ModelsTag;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Str;

class TagResource extends Resource
{
    protected static ?string $model = ModelsTag::class;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
    {
        return LayoutHelper::column($form, [
            LayoutHelper::fullColumn([
                TextInput::make('name')
                    ->label('Nom')
                    ->helperText('Génère le métalien, si non-renseigné.')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(
                        function ($state, callable $set, callable $get) {
                            if (empty($get('slug'))) {
                                $set('slug', Str::slug($state));
                            }
                        }
                    ),
                TextInput::make('slug')
                    ->label('Metalien')
                    ->required()
                    ->unique(ModelsTag::class, 'slug', fn ($record) => $record),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('posts_count')
                    ->label('Articles'),
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
            ->defaultSort('updated_at', 'desc')
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
