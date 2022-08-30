<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum LanguageEnum: string
{
    use LazyEnum;

    case en = 'en';
    case fr = 'fr';
}
