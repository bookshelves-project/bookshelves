<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self xl()
 * @method static self lg()
 * @method static self md()
 * @method static self sm()
 * @method static self xs()
 */
final class CountSizeEnum extends Enum
{
    protected static function values(): Closure
    {
        return fn (string $name) => mb_strtolower($name);
    }
}
