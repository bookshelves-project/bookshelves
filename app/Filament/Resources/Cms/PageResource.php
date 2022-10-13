<?php

namespace App\Filament\Resources\Cms;

use App\Enums\BuilderEnum;
use App\Enums\TemplateEnum;
use App\Filament\Resources\Cms\PageResource\Pages;
use App\Filament\TemplateShortcutRepeater;
use App\Models\Page;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Kiwilan\Steward\Enums\LanguageEnum;
use Kiwilan\Steward\Filament\FormHelper;
use Kiwilan\Steward\Filament\LayoutHelper;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $modelLabel = 'Page';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'CMS';

    public static function form(Form $form): Form
    {
        return LayoutHelper::container([
            LayoutHelper::column(
                [
                    FormHelper::getName('title'),
                    Forms\Components\TextInput::make('slug')
                        ->label('Metalink'),
                    // TemplateShortcutRepeater::home(),
                    Forms\Components\Repeater::make('content')
                        ->schema(function (Closure $get) {
                            $method = $get('template');
                            return TemplateShortcutRepeater::{$method}();
                            // return TemplateShortcutRepeater::home();
                        })
                        ->label('Content')
                        ->columns(1)
                        ->maxItems(1)
                        ->orderable(fn () => false)
                        ->columnSpan(2),
                ],
            ),
            LayoutHelper::column(
                [
                    Forms\Components\Select::make('language')
                        ->options(LanguageEnum::toArray())
                        ->label('Language'),
                    // Forms\Components\Select::make('builder')
                    //     ->options(BuilderEnum::toArray())
                    //     ->label('Builder'),
                    Forms\Components\Select::make('template')
                        ->options(TemplateEnum::toArray())
                        ->label('Template')
                        ->helperText('Select template type.')
                        ->default(TemplateEnum::basic->value)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set) {
                            $set('content', []);
                        }),
                ],
                width: 1
            ),
        ], $form);
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
                Tables\Columns\TextColumn::make('title')
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
