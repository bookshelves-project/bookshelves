<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum BookTypeEnum: string
{
    use LazyEnum;

    case audio = 'audio';

    case comic = 'comic';

    case novel = 'novel';

    case unknown = 'unknown';
}
