<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

/**
 * List of available formats.
 *
 * Check `ParserEngine::create()` if you want to add new format.
 *
 * ```php
 * $engine = match ($engine->format) {
 *   BookFormatEnum::epub => EpubModule::create($engine),
 *   default => false,
 * };
 * ```
 * For `download` link, the last value will be the first possibility.
 */
enum BookFormatEnum: string
{
    use LazyEnum;

    case pdf = 'pdf';
    case cbr = 'cbr';
    case cbz = 'cbz';
    case epub = 'epub';
}
