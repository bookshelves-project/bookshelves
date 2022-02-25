<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum ChartColorEnum: string
{
    use EnumMethods;

    case color_e2e0ff = '#e2e0ff';

    case color_c4c1ff = '#c4c1ff';

    case color_a7a1ff = '#a7a1ff';

    case color_8982ff = '#8982ff';

    case color_6c63ff = '#6c63ff';

    case color_564fcc = '#564fcc';

    case color_413b99 = '#413b99';

    case color_2b2866 = '#2b2866';

    case color_161433 = '#161433';
}
