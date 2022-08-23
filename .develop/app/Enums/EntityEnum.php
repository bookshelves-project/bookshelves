<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum EntityEnum: string
{
    use EnumMethods;

    case book = 'book';
    case author = 'author';
    case serie = 'serie';
    case entity = 'entity';
    case feed = 'feed';
}
