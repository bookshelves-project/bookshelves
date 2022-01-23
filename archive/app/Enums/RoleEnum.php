<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self admin()
 * @method static self publisher()
 * @method static self user()
 */
final class RoleEnum extends Enum
{
    protected static function values(): Closure
    {
        return fn (string $name) => mb_strtolower($name);
    }
}
