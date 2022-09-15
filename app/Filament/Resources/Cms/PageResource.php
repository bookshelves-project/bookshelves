<?php

namespace App\Filament\Resources\Cms;

use App\Enums\LanguageEnum;
use App\Enums\TemplateEnum;
use App\Filament\LayoutHelper;
use App\Filament\Resources\Cms\PageResource\Pages;
use App\Filament\TemplateHelper;
use App\Models\Page;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $modelLabel = 'Page';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'CMS';

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

        return LayoutHelper::column($form, [
            LayoutHelper::fullColumn(
                [
                    Forms\Components\TextInput::make('title')
                        ->label('Title')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                            $set('slug', Str::slug("{$state} {$get('language')}"));
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->disabled()
                        ->unique(Page::class, 'slug', fn ($record) => $record),
                    // Forms\Components\Select::make('language')
                    //     ->label('Language')
                    //     ->options(LanguageEnum::toArray())
                    //     ->default(LanguageEnum::en->value),
                    Forms\Components\Select::make('language')
                        ->options(LanguageEnum::toArray())
                        ->default(LanguageEnum::en->value)
                        ->label('Language')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                            $set('slug', Str::slug("{$get('title')} {$state}"));
                        }),
                    Forms\Components\Select::make('template')
                        ->options(TemplateEnum::toArray())
                        ->label('Template')
                        ->helperText('Select type of template.')
                        ->default(TemplateEnum::basic->value)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set) {
                            $set('content', []);
                        }),
                    LayoutHelper::card('SEO', [
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Titre')
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Description')
                            ->columnSpan(2),
                    ]),
                    // Forms\Components\Repeater::make('content')
                    //     ->schema(function (Closure $get) {
                    //         $method = $get('template');
                    //         return TemplateHelper::{$method}();
                    //     })
                    //     ->columns(1)
                    //     ->maxItems(1)
                    //     ->orderable(fn () => false)
                    //     ->columnSpan(2),
                    TemplateHelper::home(),
                ]
            ),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('template')
                    ->label('Template')
                    ->colors([
                        'primary',
                        'success' => TemplateEnum::basic,
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('language')
                    ->label('Language')
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
