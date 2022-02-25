<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self color_e2e0ff()
 * @method static self color_c4c1ff()
 * @method static self color_a7a1ff()
 * @method static self color_8982ff()
 * @method static self color_6c63ff()
 * @method static self color_564fcc()
 * @method static self color_413b99()
 * @method static self color_2b2866()
 * @method static self color_161433()
 */
final class ChartColorEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'color_e2e0ff' => '#e2e0ff',
            'color_c4c1ff' => '#c4c1ff',
            'color_a7a1ff' => '#a7a1ff',
            'color_8982ff' => '#8982ff',
            'color_6c63ff' => '#6c63ff',
            'color_564fcc' => '#564fcc',
            'color_413b99' => '#413b99',
            'color_2b2866' => '#2b2866',
            'color_161433' => '#161433',
        ];
    }
}
