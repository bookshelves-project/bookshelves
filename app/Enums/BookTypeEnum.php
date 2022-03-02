<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum BookTypeEnum: string
{
    use EnumMethods;

    case handbook = 'handbook';
    case essay = 'essay';
    case comic = 'comic';
    case novel = 'novel';
    case audio = 'audio';
}
