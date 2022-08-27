<?php

namespace App\Traits;

use BackedEnum;
use Closure;
use Exception;
use Lang;
use ReflectionClass;
use ReflectionEnum;
use Str;

trait LazyEnum
{
    public static function tryFromCase(string $caseName): ?self
    {
        $rc = new ReflectionEnum(self::class);
        return $rc->hasCase($caseName) ? $rc->getConstant($caseName) : null;
    }

    /**
     * @throws Exception
     */
    public static function fromCase(string $caseName): self
    {
        return self::tryFrom($caseName) ?? throw new Exception('Enum '.$caseName.' not found in '.self::class);
    }

    public static function toList()
    {
        $list = [];
        foreach (self::cases() as $enum) {
            if ($enum instanceof BackedEnum) {
                $list[$enum->value] = $enum->value;
            // @phpstan-ignore-next-line
            } else {
                array_push($enum);
            }
        }

        return $list;
    }

    // public static function toArray()
    // {
    //     $list = [];
    //     foreach (self::cases() as $enum) {
    //         $list[$enum->name] = $enum->value;
    //     }

    //     return $list;
    // }

    public static function toNames()
    {
        $array = [];

        foreach (static::cases() as $definition) {
            $array[$definition->name] = $definition->name;
        }

        return $array;
    }

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
        $class_slug = Str::kebab($class);
        $class_slug = str_replace('-enum', '', $class_slug);

        foreach (static::cases() as $definition) {
            $locale = "enums.{$class_slug}.{$definition->value}";
            $array[$definition->name] = Lang::has($locale)
                ? __($locale)
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

    public function i18n()
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
