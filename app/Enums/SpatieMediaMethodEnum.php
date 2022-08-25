<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum SpatieMediaMethodEnum: string
{
    use LazyEnum;

    case addMediaFromString = 'addMediaFromString';
    case addMediaFromBase64 = 'addMediaFromBase64';
    case addMediaFromDisk = 'addMediaFromDisk';
}
