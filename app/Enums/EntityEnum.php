<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;
use Closure;

enum EntityEnum: string
{
    use EnumMethods;

    case book = 'book';

    case author = 'author';

    case serie = 'serie';

    case feed = 'feed';

    protected static function values(): Closure
    {
        return fn (string $name) => 'App\Models\\'.ucfirst(mb_strtolower($name));
    }
}
