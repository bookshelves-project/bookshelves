<?php

namespace App\Filament\Resources\Settings;

use App\Enums\UserRole;
use App\Filament\FormHelper;
use App\Filament\LayoutHelper;
use App\Filament\Resources\Settings\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Avancé';

    protected static ?string $modelLabel = 'Utilisateur';

    public static function form(Form $form): Form
    {
        return LayoutHelper::column($form, [
            LayoutHelper::fullColumn([
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->unique(User::class, 'email', fn ($record) => $record),
                TextInput::make('password')
                    ->label('Mot de passe')
                    ->password()
                    ->required()
                    ->hiddenOn('edit'),
                TextInput::make('password_confirmation')
                    ->label('Confirmation du mot de passe')
                    ->password()
                    ->same('password')
                    ->required()
                    ->hiddenOn('edit'),
                Toggle::make('is_blocked')
                    ->label('Bloqué·e')
                    ->helperText("Bloquer la connexion de l'utilisateur.")
                    ->columnSpan(2),
                Select::make('role')
                    ->label('Rôle')
                    ->options(UserRole::toList())
                    ->default(UserRole::editor->value)
                    ->hidden(FormHelper::checkRole())
                    ->required(),
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
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                BooleanColumn::make('is_blocked')
                    ->label('Bloqué·e')
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->sortable(),
                BadgeColumn::make('role')
                    ->label('Rôle')
                    ->colors([
                        'primary',
                        'danger' => UserRole::super_admin->value,
                        'warning' => UserRole::admin->value,
                        'success' => UserRole::editor->value,
                    ])
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
