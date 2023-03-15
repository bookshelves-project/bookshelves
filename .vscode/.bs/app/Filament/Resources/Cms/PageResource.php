<?php

namespace App\Filament\Resources\Cms;

use App\Enums\TemplateEnum;
use App\Filament\Resources\Cms\PageResource\Pages;
use App\Filament\TemplateConfig;
use App\Models\Page;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Kiwilan\Steward\Enums\LanguageEnum;
use Kiwilan\Steward\Filament\Config\FilamentForm;
use Kiwilan\Steward\Filament\Config\FilamentLayout;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Page';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'CMS';

    public static function form(Form $form): Form
    {
        return FilamentLayout::make($form)
            ->schema([
                FilamentLayout::column([
                    [
                        FilamentForm::getName('title'),
                        Forms\Components\TextInput::make('slug')
                            ->label('Metalink'),
                        Forms\Components\Select::make('language')
                            ->options(LanguageEnum::toArray())
                            ->label('Language')
                            ->columns(1),
                        Forms\Components\Select::make('template')
                            ->options(TemplateEnum::toArray())
                            ->label('Template')
                            ->helperText('Select template type.')
                            ->default(TemplateEnum::about->value)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Closure $set) {
                                $set('content', []);
                            })
                            ->columns(1),
                    ],
                    [
                        Forms\Components\Repeater::make('content')
                            ->schema(function (Closure $get) {
                                $method = $get('template');
                                return TemplateConfig::{$method}();
                            })
                            ->label('Content')
                            ->maxItems(1)
                            ->orderable(fn () => false)
                            ->columnSpan(2),
                    ],
                ]),
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
            ]);
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
