<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum PostCategoryEnum: string
{
    use LazyEnum;

    case calibre = 'calibre';

    case ereader = 'ereader';
}
