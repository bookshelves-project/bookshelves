<?php

namespace App\Services;

use Illuminate\Support\Str;

class MarkdownService
{
    public static function convertToHTML(?string $markdown): ?string
    {
        return $markdown ? Str::markdown($markdown) : null;
    }
}
