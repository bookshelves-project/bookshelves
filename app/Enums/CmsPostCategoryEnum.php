<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum CmsPostCategoryEnum: string
{
    use LazyEnum;

    case calibre = 'calibre';
    case ereader = 'ereader';
}
