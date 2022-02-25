<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

/**
 * Check `ParserEngine::class`, `ConverterEngine::class` if you want to add new format.
 */
enum BookFormatEnum: string
{
    use EnumMethods;

    case epub = 'epub';
    case cbz = 'cbz';
    case pdf = 'pdf';
}
