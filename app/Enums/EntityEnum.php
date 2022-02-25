<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self book()
 * @method static self author()
 * @method static self serie()
 * @method static self feed()
 */
final class EntityEnum extends Enum
{
    protected static function values(): Closure
    {
        return fn (string $name) => 'App\Models\\'.ucfirst(mb_strtolower($name));
    }
}
