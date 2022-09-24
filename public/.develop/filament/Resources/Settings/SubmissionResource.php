<?php

namespace App\Filament\Resources\Settings;

use App\Filament\FormHelper;
use App\Filament\LayoutHelper;
use App\Filament\Resources\Settings\SubmissionResource\Pages;
use App\Forms\Components\AttachmentUrl;
use App\Models\Submission;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;

class SubmissionResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';

    protected static ?string $navigationGroup = 'Avancé';

    protected static ?string $modelLabel = 'Messages';

    public static function form(Form $form): Form
    {
        return LayoutHelper::column($form, [
            LayoutHelper::fullColumn([
                TextInput::make('subject')
                    ->label('Sujet')
                    ->required()
                    ->columnSpan(2)
                    ->disabled(FormHelper::disabledOn('edit')),
                TextInput::make('name')
                    ->label('Nom')
                    ->required()
                    ->disabled(FormHelper::disabledOn('edit')),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->disabled(FormHelper::disabledOn('edit')),
                TextInput::make('phone')
                    ->label('Téléphone')
                    ->required()
                    ->disabled(FormHelper::disabledOn('edit')),
                TextInput::make('society')
                    ->label('Société')
                    ->required()
                    ->disabled(FormHelper::disabledOn('edit')),
                Textarea::make('message')
                    ->label('Message')
                    ->required()
                    ->columnSpan(2)
                    ->disabled(FormHelper::disabledOn('edit')),
                Toggle::make('accept_conditions')
                    ->label('A accepté les conditions')
                    ->required()
                    ->disabled(FormHelper::disabledOn('edit')),
                Toggle::make('want_newsletter')
                    ->label('Souhaite recevoir la newsletter')
                    ->disabled(FormHelper::disabledOn('edit')),
                AttachmentUrl::make('cv')
                    ->label('CV')
                    ->prefix()
                    ->disabled(FormHelper::disabledOn('edit')),
                AttachmentUrl::make('letter')
                    ->label('Lettre de motivation')
                    ->disabled(FormHelper::disabledOn('edit')),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject')
                    ->label('Sujet')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Réception')
                    ->date('Y/m/d H:i')
                    ->sortable(),
            ])
            ->filters([
                FormHelper::getDateFilter('created_at'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Action::make('cv')
                    ->label('CV')
                    ->icon('heroicon-o-download')
                    ->url(fn (Submission $record) => $record->cv_file)
                    ->openUrlInNewTab(),
                Action::make('letter')
                    ->label('LM')
                    ->icon('heroicon-o-download')
                    ->url(fn (Submission $record) => $record->cv_file)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListSubmissions::route('/'),
            'edit' => Pages\EditSubmission::route('/{record}/edit'),
        ];
    }
}
