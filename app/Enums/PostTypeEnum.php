<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum PostTypeEnum: string
{
    use LazyEnum;

    case seo = 'seo';
    case development = 'development';
}
