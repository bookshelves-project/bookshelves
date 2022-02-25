<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;
use Closure;

enum RoleEnum: string
{
    use EnumMethods;

    case super_admin = 'super_admin';

    case admin = 'admin';

    case publisher = 'publisher';

    case user = 'user';

    protected static function values(): Closure
    {
        return fn (string $name) => mb_strtolower($name);
    }

    public function equals(...$others): bool
    {
        foreach ($others as $other) {
            if (
                get_class($this) === get_class($other)
                && $this->value === $other->value
            ) {
                return true;
            }
        }

        return false;
    }
}
