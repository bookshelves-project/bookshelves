<?php

namespace App\Filament;

use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Str;

class LayoutHelper
{
    public static function column(Form $form, mixed $columns = null)
    {
        return $form
            ->schema([
                ...$columns,
            ])
            ->columns([
                'sm' => 2,
                'lg' => null,
            ])
        ;
    }

    public static function fullColumn(array|Closure $firstPart = [], array|Closure $secondPart = [], array|Closure $thirdPart = [])
    {
        return Forms\Components\Group::make()
            ->schema([
                ! empty($firstPart)
                    ? Forms\Components\Card::make()
                        ->schema($firstPart)
                        ->columns([
                            'sm' => 2,
                        ])
                    : Forms\Components\Group::make(),
                ! empty($secondPart)
                    ? Forms\Components\Card::make()
                        ->schema($secondPart)
                        ->columns([
                            'sm' => 2,
                        ])
                    : Forms\Components\Group::make(),
                ! empty($thirdPart)
                ? Forms\Components\Card::make()
                    ->schema($thirdPart)
                    ->columns([
                        'sm' => 2,
                    ])
                : Forms\Components\Group::make(),
            ])
            ->columnSpan([
                'sm' => 2,
            ])
        ;
    }

    public static function columns(Form $form, mixed $columns = null)
    {
        return $form
            ->schema([
                ...$columns,
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ])
        ;
    }

    public static function mainColumn(array|Closure $firstPart = [], array|Closure $secondPart = [], array|Closure $thirdPart = [])
    {
        return Forms\Components\Group::make()
            ->schema([
                ! empty($firstPart)
                    ? Forms\Components\Card::make()
                        ->schema($firstPart)
                        ->columns([
                            'sm' => 2,
                        ])
                    : Forms\Components\Group::make(),
                ! empty($secondPart)
                    ? Forms\Components\Card::make()
                        ->schema($secondPart)
                        ->columns([
                            'sm' => 2,
                        ])
                    : Forms\Components\Group::make(),
                ! empty($thirdPart)
                ? Forms\Components\Card::make()
                    ->schema($thirdPart)
                    ->columns([
                        'sm' => 2,
                    ])
                : Forms\Components\Group::make(),
            ])
            ->columnSpan([
                'sm' => 2,
            ])
        ;
    }

    public static function sideColumn(array|Closure $firstPart = [], array|Closure $secondPart = [], array|Closure $thirdPart = [])
    {
        return Forms\Components\Group::make()
            ->schema([
                ! empty($firstPart)
                    ? Forms\Components\Card::make()
                        ->schema($firstPart)
                        ->columns(1)
                    : Forms\Components\Group::make(),
                ! empty($secondPart)
                    ? Forms\Components\Card::make()
                        ->schema($secondPart)
                        ->columns(1)
                    : Forms\Components\Group::make(),
                ! empty($thirdPart)
                ? Forms\Components\Card::make()
                    ->schema($thirdPart)
                    ->columns(1)
                : Forms\Components\Group::make(),

            ])
            ->columnSpan(1)
        ;
    }

    public static function card(string $title, array|Closure $card = [], int $columns = 2)
    {
        return Forms\Components\Card::make()
            ->schema([
                Forms\Components\Placeholder::make(Str::slug($title))
                    ->label($title)
                    ->columnSpan(2),
                ...$card,
            ])
            ->columns($columns)
        ;
    }
}
