<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum SpatieMediaMethodEnum: string
{
    use LazyEnum;

    case addMediaFromString = 'addMediaFromString';
    case addMediaFromBase64 = 'addMediaFromBase64';
    case addMediaFromDisk = 'addMediaFromDisk';
}
