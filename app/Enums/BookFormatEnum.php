<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Kiwilan\Steward\Traits\LazyEnum;

/**
 * List of available formats.
 *
 * Check `ParserEngine::make()` if you want to add new format.
 *
 * ```php
 * $engine = match ($engine->format) {
 *   BookFormatEnum::epub => EpubModule::create($engine),
 *   default => false,
 * };
 * ```
 * For `download` link, the last value will be the first possibility.
 */
enum BookFormatEnum: string implements HasColor, HasIcon, HasLabel
{
    use LazyEnum;

    public const ALLOWED_EXTENSIONS = ['mp3', 'm4b', 'pdf', 'cb7', 'cba', 'cbr', 'cbt', 'cbz', 'epub'];

    case unknown = 'unknown';

    case audio = 'audio';

    case pdf = 'pdf';

    case cba = 'cba';

    case epub = 'epub';

    public static function fromExtension(string $extension): static
    {
        return match ($extension) {
            'mp3', 'm4b' => self::audio,
            'pdf' => self::pdf,
            'cb7', 'cba', 'cbr', 'cbt', 'cbz' => self::cba,
            'epub' => self::epub,
            default => self::unknown,
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::audio => 'info',
            self::cba => 'warning',
            self::epub => 'success',
            self::pdf => 'danger',
            default => 'primary',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::audio => 'AUDIO',
            self::cba => 'CBA',
            self::epub => 'EPUB',
            self::pdf => 'PDF',
            default => 'Unknown',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::audio => 'heroicon-o-musical-note',
            self::cba => 'heroicon-o-archive-box',
            self::epub => 'heroicon-o-archive-box',
            self::pdf => 'heroicon-o-document',
            default => 'heroicon-o-document',
        };
    }
}
