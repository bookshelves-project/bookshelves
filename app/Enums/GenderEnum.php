<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum GenderEnum: string
{
    use EnumMethods;

    case unknown = 'unknown';

    case woman = 'woman';

    case nonbinary = 'nonbinary';

    case genderfluid = 'genderfluid';

    case agender = 'agender';

    case man = 'man';
}
