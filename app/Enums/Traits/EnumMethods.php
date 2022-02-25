<?php

namespace App\Enums\Traits;

use Illuminate\Support\Str;

trait EnumMethods
{
    public static function labels(): array
    {
        $class = str_replace('App\Enums\\', '', static::class);
        $class = str_replace('Enum', '', $class);
        $class = Str::snake($class);

        return collect(__("enum.enums.{$class}"))->toArray();
    }

    public static function toArray(): array
    {
        return array_map(
            fn ($value) => $value->value,
            static::cases(),
        );
    }
}
