<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Kiwilan\Steward\Traits\LazyEnum;

enum BookTypeEnum: string implements HasColor, HasIcon, HasLabel
{
    use LazyEnum;

    case book = 'book';

    case comic = 'comic';

    case manga = 'manga';

    case audiobook = 'audiobook';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::audiobook => 'info',
            self::book => 'success',
            self::comic => 'warning',
            self::manga => 'warning',
        };
    }

    public static function getLabels(): array
    {
        $items = [];
        foreach (self::cases() as $enum) {
            $items[$enum->value] = $enum->getLabel();
        }

        return $items;
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            default => ucfirst($this->value),
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
