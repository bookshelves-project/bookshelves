<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum TagTypeEnum: string
{
    use LazyEnum;

    case tag = 'tag';
    case genre = 'genre';
}
