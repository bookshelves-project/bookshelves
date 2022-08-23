<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum BookTypeEnum: string
{
    use EnumMethods;

    case audio = 'audio';
    case comic = 'comic';
    case essay = 'essay';
    case handbook = 'handbook';
    case novel = 'novel';
}
