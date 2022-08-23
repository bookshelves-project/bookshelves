<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum MediaDiskEnum: string
{
    use EnumMethods;

    case cms = 'cms';
    case cover = 'cover';
    case format = 'format';
    case user = 'user';
}
