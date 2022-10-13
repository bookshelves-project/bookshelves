<?php

namespace App\Filament;

use Filament\Forms;
use Kiwilan\Steward\Filament\BuilderHelper;
use Kiwilan\Steward\Filament\LayoutHelper;

class TemplateShortcut
{
    public static function home()
    {
        return LayoutHelper::card([
            BuilderHelper::container([
                BuilderHelper::block([
                    BuilderHelper::display(),
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
                BuilderHelper::block([
                    BuilderHelper::display(),
                    Forms\Components\TextInput::make('eyebrow')
                        ->label('Eyebrow'),
                    Forms\Components\TextInput::make('title')
                        ->label('Title'),
                    Forms\Components\Textarea::make('text')
                        ->label('Text')
                        ->columnSpan(2),
                    Forms\Components\Repeater::make('list')
                        ->label('List')
                        ->schema([
                            Forms\Components\TextInput::make('label')
                                ->label('label')
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('model')
                                ->label('model')
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('modelWhere')
                                ->label('modelWhere')
                                ->columnSpan(1),
                        ])
                        ->columns(2)
                        ->columnSpan(2)
                        ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                        ->collapsible()
                        ->collapsed(),
                ], 'statistics'),
                BuilderHelper::block([
                    BuilderHelper::display(),

                ], 'logos'),
                BuilderHelper::block([
                    BuilderHelper::display(),

                ], 'features'),
                BuilderHelper::block([
                    BuilderHelper::display(),

                ], 'highlights'),
            ]),
        ]);
    }

    public static function basic()
    {
        return BuilderHelper::container([
            BuilderHelper::block([
                Forms\Components\RichEditor::make('content')
                    ->columnSpan(2),
            ]),
        ]);
    }
}
