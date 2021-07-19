<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self ADMIN()
 * @method static self PUBLISHER()
 * @method static self USER()
 */
final class RoleEnum extends Enum
{
    protected static function values(): Closure
    {
        return fn (string $name) => mb_strtolower($name);
    }
}
