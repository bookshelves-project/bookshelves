<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;
use App\Traits\LazyEnum;

enum AuthorRoleEnum: string
{
    use LazyEnum;

    case aut = 'aut';
}
