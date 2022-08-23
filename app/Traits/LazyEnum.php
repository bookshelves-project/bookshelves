<?php

namespace App\Traits;

use BackedEnum;
use Exception;
use ReflectionEnum;

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

    public static function toArray()
    {
        $list = [];
        foreach (self::cases() as $enum) {
            $list[$enum->name] = $enum->value;
        }

        return $list;
    }
}
