<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;
use App\Traits\LazyEnum;

enum EntityEnum: string
{
    use LazyEnum;

    case book = 'book';
    case author = 'author';
    case serie = 'serie';
    case entity = 'entity';
    case feed = 'feed';
}
