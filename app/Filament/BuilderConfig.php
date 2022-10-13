<?php

namespace App\Filament;

use Filament\Forms;
use Kiwilan\Steward\Filament\StwBuilderConfig;
use Kiwilan\Steward\Filament\StwLayoutConfig;

class BuilderConfig
{
    public static function wordpress()
    {
        return StwLayoutConfig::card([
            StwBuilderConfig::container([
                StwBuilderConfig::block([
                    StwBuilderConfig::display(),
                    Forms\Components\TextInput::make('title')
                        ->label('Title')
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('hang')
                        ->label('Hang')
                        ->columnSpan(1),
                    Forms\Components\Textarea::make('text')
                        ->label('Text')
                        ->columnSpan(2),
                    Forms\Components\FileUpload::make('media')
                        ->label('Media')
                        ->columnSpan(2),
                ], 'hero'),
            ]),
        ]);
    }
}
