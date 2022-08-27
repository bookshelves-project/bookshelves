<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum UserRole: string
{
    use LazyEnum;

    case super_admin = 'super_admin';
    case admin = 'admin';
    case editor = 'editor';
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
