<?php

namespace App\Enums;

use Closure;

/**
 * @method static self super_admin()
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
