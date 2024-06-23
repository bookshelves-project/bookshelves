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

    case comic_manga = 'comic_manga';

    public function isComicOrManga(): bool
    {
        return $this === self::comic_manga;
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
            self::comic_manga => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::audiobook => 'heroicon-o-musical-note',
            self::book => 'heroicon-o-book-open',
            self::comic_manga => 'heroicon-o-chat-bubble-bottom-center',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::audiobook => __('Audiobook'),
            self::book => __('Book'),
            self::comic_manga => __('Comic/Manga'),
        };
    }
}
