<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum PostTypeEnum: string
{
    use LazyEnum;

    case seo = 'seo';
    case development = 'development';
}
