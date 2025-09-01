<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Kiwilan\Steward\Filament\Config\FilamentLayout;

class ManageGeneral extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $slug = 'pages/general';

    protected static ?string $title = 'General';

    protected static string $settings = GeneralSettings::class;

    public function form(Form $form): Form
    {
        return FilamentLayout::make($form)
            ->schema([
                FilamentLayout::column([
                    FilamentLayout::section([
                        Forms\Components\Toggle::make('notify')
                            ->label('Notifications')
                            ->helperText('Enables notifications'),
                    ]),
                ], 1),
            ]);
    }
}
