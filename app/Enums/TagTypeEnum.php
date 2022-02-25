<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum TagTypeEnum: string
{
    use EnumMethods;

    case tag = 'tag';

    case genre = 'genre';
}
