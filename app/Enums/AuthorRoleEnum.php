<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum AuthorRoleEnum: string
{
    use LazyEnum;

    case aut = 'aut';
}
