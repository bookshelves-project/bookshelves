<?php

namespace App\Filament;

use Filament\Forms;
use Kiwilan\Steward\Filament\BuilderHelper;

class TemplateShortcut
{
    public static function home()
    {
        return LayoutHelper::card('', [
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
                    Forms\Components\TextInput::make('title')
                        ->label('title'),
                    Forms\Components\Repeater::make('list')
                        ->label('List')
                        ->schema([
                            Forms\Components\TextInput::make('label')
                                ->label('label')
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('slug')
                                ->label('slug')
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('link')
                                ->label('link')
                                ->url()
                                ->columnSpan(1),
                            Forms\Components\FileUpload::make('media')
                                ->label('media')
                                ->columnSpan(2),
                        ])
                        ->columns(2)
                        ->columnSpan(2)
                        ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                        ->collapsible()
                        ->collapsed(),
                ], 'logos'),
                BuilderHelper::block([
                    BuilderHelper::display(),
                    Forms\Components\TextInput::make('title')
                        ->label('title'),
                    Forms\Components\Textarea::make('text')
                        ->label('text'),
                    Forms\Components\Repeater::make('list')
                        ->label('List')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('title')
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('slug')
                                ->label('slug')
                                ->columnSpan(1),
                            Forms\Components\Textarea::make('text')
                                ->label('text')
                                ->columnSpan(2),
                            Forms\Components\FileUpload::make('media')
                                ->label('media')
                                ->columnSpan(2),
                        ])
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                        ->columns(2)
                        ->columnSpan(2)
                        ->collapsible()
                        ->collapsed(),
                ], 'features'),
                BuilderHelper::block([
                    BuilderHelper::display(),
                    Forms\Components\Repeater::make('list')
                        ->label('List')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('title')
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('slug')
                                ->label('slug')
                                ->columnSpan(1),
                            Forms\Components\Textarea::make('text')
                                ->label('text')
                                ->columnSpan(2),
                            Forms\Components\FileUpload::make('media')
                                ->label('media')
                                ->columnSpan(2),
                            Forms\Components\Group::make()
                                ->schema([
                                    Forms\Components\Card::make()
                                        ->schema([
                                            Forms\Components\Placeholder::make('cta')
                                                ->label('CTA'),
                                            Forms\Components\TextInput::make('cta_text')
                                                ->label('cta_text'),
                                            Forms\Components\TextInput::make('cta_link')
                                                ->label('cta_link'),
                                        ])
                                        ->columnSpan(1),
                                    Forms\Components\Card::make()
                                        ->schema([
                                            Forms\Components\Placeholder::make('quote')
                                                ->label('Quote'),
                                            Forms\Components\TextInput::make('quote_text')
                                                ->label('quote_text'),
                                            Forms\Components\TextInput::make('quote_author')
                                                ->label('quote_author'),
                                        ])
                                        ->columnSpan(1),
                                ])
                                ->columns(2)
                                ->columnSpan(2),

                        ])
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                        ->columns(2)
                        ->columnSpan(2)
                        ->collapsible()
                        ->collapsed(),
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
