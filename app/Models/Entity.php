<?php

namespace App\Models;

use ReflectionClass;
use Str;

class Entity
{
    public ?string $slug;
    public ?string $title;

    public static function getEntity(object $class): string
    {
        $class = new ReflectionClass($class);
        $name = $class->getShortName();

        $slug = preg_split('/(?=[A-Z])/', $name);
        $slug = implode('-', $slug);

        return Str::slug($slug);
    }
}
