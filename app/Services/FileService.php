<?php

namespace App\Services;

use Illuminate\Support\Str;

class FileService
{
    public static function setName(?string $markdown): ?string
    {
        return $markdown ? Str::markdown($markdown) : null;
    }
}
