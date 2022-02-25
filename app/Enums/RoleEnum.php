<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum RoleEnum: string
{
    use EnumMethods;

    case super_admin = 'super_admin';
    case admin = 'admin';
    case publisher = 'publisher';
    case user = 'user';

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
