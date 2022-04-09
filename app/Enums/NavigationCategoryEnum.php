<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum NavigationCategoryEnum: string
{
    use EnumMethods;

    case navbar = 'navbar';
    case footer = 'footer';
}
