<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum SpatieMediaMethodEnum: string
{
    use EnumMethods;

    case addMediaFromString = 'addMediaFromString';
    case addMediaFromBase64 = 'addMediaFromBase64';
    case addMediaFromDisk = 'addMediaFromDisk';
}
