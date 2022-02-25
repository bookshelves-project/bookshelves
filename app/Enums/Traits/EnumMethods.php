<?php

namespace App\Enums\Traits;

use Illuminate\Support\Facades\Lang;
use ReflectionClass;

trait EnumMethods
{
    public static function toValues()
    {
        $array = [];

        foreach (static::cases() as $definition) {
            $array[$definition->name] = $definition->value;
        }

        return $array;
    }

    public static function toArray()
    {
        $array = [];
        $class = new ReflectionClass(static::class);
        $class = $class->getShortName();

        foreach (static::cases() as $definition) {
            $array[$definition->name] = Lang::has("enum.enums.{$class}.{$definition->value}")
                ? __("enum.enums.{$class}.{$definition->value}")
                : $definition->value;
        }

        return $array;
    }
}
