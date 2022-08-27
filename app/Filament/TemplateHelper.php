<?php

namespace App\Filament;

use App\Enums\MediaDiskEnum;
use Filament\Forms;

class TemplateHelper
{
    public static function basic()
    {
        return [
            Forms\Components\Repeater::make('content')
                ->schema([
                    Forms\Components\MarkdownEditor::make('content')
                        ->columnSpan(2),
                ])
                ->columns(2)
                ->maxItems(1),
        ];
    }

    public static function home()
    {
        return [
            Forms\Components\Repeater::make('hero')
                ->schema([
                    Forms\Components\Toggle::make('display')
                        ->default(true)
                        ->helperText('Display or not this entry.')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('name'),
                    Forms\Components\TextInput::make('title'),
                    Forms\Components\Textarea::make('text')
                        ->columnSpan(2),
                    Forms\Components\FileUpload::make('media')
                        ->label('Media')
                        ->directory(MediaDiskEnum::cms->value),
                ])
                ->columns(2)
                ->maxItems(1),
            Forms\Components\Repeater::make('statistics')
                ->schema([
                    Forms\Components\Toggle::make('display')
                        ->default(true)
                        ->helperText('Display or not this entry.')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('eyebrow'),
                    Forms\Components\TextInput::make('title'),
                    Forms\Components\Textarea::make('text')
                        ->columnSpan(2),
                    Forms\Components\Repeater::make('list')
                        ->schema([
                            Forms\Components\Select::make('model')
                                ->options([
                                    'Book' => 'Book',
                                    'Author' => 'Author',
                                    'Serie' => 'Serie',
                                    'Publisher' => 'Publisher',
                                    'TagExtend' => 'TagExtend',
                                    'Language' => 'Language',
                                ]),
                            Forms\Components\TextInput::make('modelWhere'),
                            Forms\Components\TextInput::make('label'),
                        ])
                        ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                        ->columns(2)
                        ->columnSpan(2)
                        ->collapsible()
                        ->collapsed(),
                ])
                ->columns(2)
                ->maxItems(1),
            Forms\Components\Repeater::make('logos')
                ->schema([
                    Forms\Components\Toggle::make('display')
                        ->default(true)
                        ->helperText('Display or not this entry.')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('title')
                        ->columnSpan(2),
                    Forms\Components\Repeater::make('list')
                        ->schema([
                            Forms\Components\TextInput::make('label'),
                            Forms\Components\TextInput::make('slug'),
                            Forms\Components\TextInput::make('link')
                                ->url(),
                        ])
                        ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                        ->columns(2)
                        ->columnSpan(2)
                        ->collapsible()
                        ->collapsed(),
                ])
                ->columns(2)
                ->maxItems(1),
            Forms\Components\Repeater::make('features')
                ->schema([
                    Forms\Components\Toggle::make('display')
                        ->default(true)
                        ->helperText('Display or not this entry.')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('title')
                        ->columnSpan(2),
                    Forms\Components\Textarea::make('text')
                        ->columnSpan(2),
                    Forms\Components\Repeater::make('list')
                        ->schema([
                            Forms\Components\TextInput::make('title'),
                            Forms\Components\TextInput::make('slug'),
                            Forms\Components\Textarea::make('text')
                                ->columnSpan(2),
                        ])
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                        ->columns(2)
                        ->columnSpan(2)
                        ->collapsible()
                        ->collapsed(),
                ])
                ->columns(2)
                ->maxItems(1),
            Forms\Components\Repeater::make('highlights')
                ->schema([
                    Forms\Components\Toggle::make('display')
                        ->default(true)
                        ->helperText('Display or not this entry.')
                        ->columnSpan(2),
                    Forms\Components\Repeater::make('list')
                        ->schema([
                            Forms\Components\TextInput::make('title'),
                            Forms\Components\TextInput::make('slug'),
                            Forms\Components\Textarea::make('text')
                                ->columnSpan(2),
                            Forms\Components\Card::make()
                                ->schema([
                                    Forms\Components\Placeholder::make('cta')
                                        ->label('CTA')
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('cta_text')
                                        ->label('Text'),
                                    Forms\Components\TextInput::make('cta_link')
                                        ->label('Link'),
                                ])
                                ->columns(2),
                            Forms\Components\Card::make()
                                ->schema([
                                    Forms\Components\Placeholder::make('quote')
                                        ->label('Quotation')
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('quote_text')
                                        ->label('Text'),
                                    Forms\Components\TextInput::make('quote_author')
                                        ->label('Author'),
                                ])
                                ->columns(2),
                        ])
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                        ->collapsible()
                        ->collapsed()
                        ->columns(2),
                ])
                ->maxItems(1),
        ];
    }

    public static function about()
    {
        return [
            Forms\Components\Repeater::make('hero')
                ->schema([
                    Forms\Components\Toggle::make('display')
                        ->default(true)
                        ->helperText('Display or not this entry.')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('name'),
                    Forms\Components\TextInput::make('title'),
                    Forms\Components\Textarea::make('text')
                        ->columnSpan(2),
                ])
                ->columns(2)
                ->maxItems(1),
        ];
    }
}
