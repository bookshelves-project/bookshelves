<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum ChartColorEnum: string
{
    use EnumMethods;

    case color_003f5c = '#003f5c';
    case color_2f4b7c = '#2f4b7c';
    case color_665191 = '#665191';
    case color_a05195 = '#a05195';
    case color_d45087 = '#d45087';
    case color_f95d6a = '#f95d6a';
    case color_ff7c43 = '#ff7c43';
    case color_ffa600 = '#ffa600';
}
