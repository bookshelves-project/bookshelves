<?php

namespace App\Filament\Resources\Creation;

use App\Filament\LayoutHelper;
use App\Filament\Resources\Creation\ReferenceCategoryResource\Pages;
use App\Models\ReferenceCategory;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Str;

class ReferenceCategoryResource extends Resource
{
    protected static ?string $model = ReferenceCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Créations';

    protected static ?string $modelLabel = 'Catégorie';

    public static function form(Form $form): Form
    {
        return LayoutHelper::column($form, [
            LayoutHelper::fullColumn(
                [
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
                        ->unique(ReferenceCategory::class, 'slug', fn ($record) => $record),
                ]
            ),
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
                BadgeColumn::make('references_count')
                    ->label('Réalisations'),
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
            'index' => Pages\ListReferenceCategories::route('/'),
            'create' => Pages\CreateReferenceCategory::route('/create'),
            'edit' => Pages\EditReferenceCategory::route('/{record}/edit'),
        ];
    }
}
