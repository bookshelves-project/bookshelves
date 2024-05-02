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

    case comic = 'comic';

    case manga = 'manga';

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
            self::comic => 'warning',
            self::manga => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::audiobook => 'heroicon-o-musical-note',
            self::book => 'heroicon-o-book-open',
            self::comic => 'heroicon-o-chat-bubble-bottom-center',
            self::manga => 'heroicon-o-chat-bubble-left-right',
        };
    }
}
