<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self XL()
 * @method static self LG()
 * @method static self MD()
 * @method static self SM()
 * @method static self XS()
 */
final class CountSizeEnum extends Enum
{
    protected static function values(): Closure
    {
        return fn (string $name) => mb_strtolower($name);
    }
}
