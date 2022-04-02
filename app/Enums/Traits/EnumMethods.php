<?php

namespace App\Enums\Traits;

use Closure;
use Illuminate\Support\Facades\App;
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

    public function trans()
    {
        $class = new ReflectionClass(static::class);
        $class = $class->getShortName();

        return Lang::has("enum.enums.{$class}.{$this->name}")
            ? __("enum.enums.{$class}.{$this->name}")
            : $this->name;
    }

    protected static function values(): Closure
    {
        return fn (string $name) => mb_strtolower($name);
    }
}
