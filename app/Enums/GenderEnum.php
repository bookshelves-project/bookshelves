<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self NONE()
 * @method static self WOMAN()
 * @method static self NONBINARY()
 * @method static self GENDERFLUID()
 * @method static self AGENDER()
 * @method static self MAN()
 */
final class GenderEnum extends Enum
{
    protected static function values(): Closure
    {
        return fn (string $name) => mb_strtolower($name);
    }
}
