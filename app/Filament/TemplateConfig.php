<?php

namespace App\Filament;

use Filament\Forms;
use Kiwilan\Steward\Filament\StwBuilderConfig;

class TemplateConfig
{
    public static function block(array $content = [], string $make = 'block', string $label = 'Block')
    {
        return Forms\Components\Repeater::make($make)
            ->schema([
                StwBuilderConfig::display(),
                ...$content,
            ])
            ->disableItemMovement()
            ->maxItems(1)
            ->columnSpan(2)
            ->label($label)
            ->createItemButtonLabel("Add {$label}")
        ;
    }

    public static function home()
    {
        return [
            TemplateConfig::block([
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
            ], 'hero', 'Hero'),
            TemplateConfig::block([
                Forms\Components\TextInput::make('eyebrow')
                    ->label('Eyebrow')
                    ->columnSpan(2),
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->columnSpan(2),
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
                            ->columnSpan(2),
                    ])
                    ->columns(2)
                    ->columnSpan(2)
                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                    ->collapsible()
                    ->collapsed(),
            ], 'statistics', 'Statistics'),
            TemplateConfig::block([
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
                            ->columnSpan(2),
                        Forms\Components\FileUpload::make('media')
                            ->label('media')
                            ->columnSpan(2),
                    ])
                    ->columns(2)
                    ->columnSpan(2)
                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                    ->collapsible()
                    ->collapsed(),
            ], 'logos', 'Logos'),
            TemplateConfig::block([
                Forms\Components\TextInput::make('title')
                    ->label('title')
                    ->columnSpan(2),
                Forms\Components\Textarea::make('text')
                    ->label('text')
                    ->columnSpan(2),
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
            ], 'features', 'Features'),
            TemplateConfig::block([
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
                                    ->columnSpan(2),
                                Forms\Components\Card::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('quote')
                                            ->label('Quote'),
                                        Forms\Components\TextInput::make('quote_text')
                                            ->label('quote_text'),
                                        Forms\Components\TextInput::make('quote_author')
                                            ->label('quote_author'),
                                    ])
                                    ->columnSpan(2),
                            ])
                            ->columns(2)
                            ->columnSpan(2),

                    ])
                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                    ->columns(2)
                    ->columnSpan(2)
                    ->collapsible()
                    ->collapsed(),
            ], 'highlights', 'Highlights'),
        ];
    }

    public static function about()
    {
        return [
            TemplateConfig::block([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->columnSpan(1),
                Forms\Components\Textarea::make('text')
                    ->label('Text')
                    ->columnSpan(2),
                Forms\Components\FileUpload::make('media')
                    ->label('Media')
                    ->columnSpan(2),
                Forms\Components\RichEditor::make('content')
                    ->columnSpan(2),
            ]),
        ];
    }
}
