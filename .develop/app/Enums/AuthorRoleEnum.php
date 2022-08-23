<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum AuthorRoleEnum: string
{
    use EnumMethods;

    case aut = 'aut';
}
