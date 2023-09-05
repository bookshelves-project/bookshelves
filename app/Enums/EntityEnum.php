<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum EntityEnum: string
{
    use LazyEnum;

    case book = 'book';

    case author = 'author';

    case serie = 'serie';

    case entity = 'entity';

    case feed = 'feed';
}
