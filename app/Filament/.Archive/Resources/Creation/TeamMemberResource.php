<?php

namespace App\Filament\Resources\Creation;

use App\Enums\MediaTypeEnum;
use App\Filament\FormHelper;
use App\Filament\LayoutHelper;
use App\Filament\Resources\Creation\TeamMemberResource\Pages;
use App\Models\TeamMember;
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
use Str;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Créations';

    protected static ?string $modelLabel = "Membre d'équipe";

    protected static ?string $pluralModelLabel = "Membres d'équipe";

    public static function form(Form $form): Form
    {
        return LayoutHelper::columns($form, [
            LayoutHelper::mainColumn([
                TextInput::make('firstname')
                    ->label('Prénom')
                    ->reactive()
                    ->afterStateUpdated(fn ($state, $set, $get) => $set('slug', Str::slug("{$state} {$get('lastname')}")))
                    ->required(),
                TextInput::make('lastname')
                    ->label('Nom')
                    ->reactive()
                    ->afterStateUpdated(fn ($state, $set, $get) => $set('slug', Str::slug("{$get('firstname')} {$state}"))),
                TextInput::make('function')
                    ->label('Fonction'),
                TextInput::make('sort')
                    ->label('Tri')
                    ->type('number')
                    ->default(0),
                Textarea::make('description')
                    ->columnSpan(2),
            ]),
            LayoutHelper::sideColumn([
                FormHelper::getImageField(type: MediaTypeEnum::team_members),
                TextInput::make('slug')
                    ->label('Métalien')
                    ->required()
                    ->unique(TeamMember::class, 'slug', fn ($record) => $record),
                Toggle::make('is_active')
                    ->label('Actif·ve')
                    ->default(true),
            ]),
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
                TextColumn::make('firstname')
                    ->label('Prénom')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('lastname')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('function')
                    ->label('Fonction')
                    ->searchable()
                    ->sortable(),
                BooleanColumn::make('is_active')
                    ->label('Actif·ve')
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
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
