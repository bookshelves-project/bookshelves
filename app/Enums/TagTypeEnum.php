<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum TagTypeEnum: string
{
    use LazyEnum;

    case tag = 'tag';
    case genre = 'genre';
}
