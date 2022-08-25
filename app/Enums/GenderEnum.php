<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum GenderEnum: string
{
    use LazyEnum;

    case unknown = 'unknown';
    case woman = 'woman';
    case nonbinary = 'nonbinary';
    case genderfluid = 'genderfluid';
    case agender = 'agender';
    case man = 'man';
}
