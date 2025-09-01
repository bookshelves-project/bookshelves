<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Kiwilan\Steward\Traits\LazyEnum;

enum LibraryTypeEnum: string implements HasColor, HasIcon, HasLabel
{
    use LazyEnum;

    case audiobook = 'audiobook';

    case book = 'book';

    case graphic = 'graphic';

    /**
     * Check if the library type is graphic (comic or manga).
     */
    public function isGraphic(): bool
    {
        return $this === self::graphic;
    }

    public function isAudiobook(): bool
    {
        return $this === self::audiobook;
    }

    public static function getLabels(): array
    {
        $items = [];
        foreach (self::cases() as $enum) {
            $items[$enum->value] = $enum->getLabel();
        }

        return $items;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::audiobook => 'info',
            self::book => 'success',
            self::graphic => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::audiobook => 'heroicon-o-musical-note',
            self::book => 'heroicon-o-book-open',
            self::graphic => 'heroicon-o-chat-bubble-bottom-center',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::audiobook => __('Audiobook'),
            self::book => __('Book'),
            self::graphic => __('Graphic'),
        };
    }
}
