<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum BookTypeEnum: string
{
    use LazyEnum;

    case audio = 'audio';

    case comic = 'comic';

    // case essay = 'essay';

    // case handbook = 'handbook';

    case novel = 'novel';
}
