<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum CountSizeEnum: string
{
    use EnumMethods;

    case xl = 'xl';
    case lg = 'lg';
    case md = 'md';
    case sm = 'sm';
    case xs = 'xs';
}
