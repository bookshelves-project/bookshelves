<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum PostCategoryEnum: string
{
    use LazyEnum;

    case calibre = 'calibre';
    case ereader = 'ereader';
}
