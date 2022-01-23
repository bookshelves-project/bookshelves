<?php

namespace App\Enums;

class Enum extends \Spatie\Enum\Laravel\Enum
{
    protected static function labels(): array
    {
        return collect(__('enum::validation.enums.'.static::class))->toArray();
    }
}
