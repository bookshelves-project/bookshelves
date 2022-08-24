<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;
use App\Traits\LazyEnum;

enum TagTypeEnum: string
{
    use LazyEnum;

    case tag = 'tag';
    case genre = 'genre';
}
