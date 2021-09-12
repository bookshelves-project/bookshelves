<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self BOOK()
 * @method static self AUTHOR()
 * @method static self SERIE()
 * @method static self FEED()
 */
final class EntitiesEnum extends Enum
{
    protected static function values(): Closure
    {
        return fn (string $name) => 'App\Models\\' . ucfirst(mb_strtolower($name));
    }
}
