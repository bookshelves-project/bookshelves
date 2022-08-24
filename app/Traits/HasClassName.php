<?php

namespace App\Traits;

/**
 * Get class name.
 */
trait HasClassName
{
    public function getClassName(bool $withPlural = false)
    {
        $class = strtolower(str_replace('App\Models\\', '', get_class($this)));
        if ($withPlural) {
            return $class.'s';
        }

        return $class;
    }

    public function getClassNamespace()
    {
        return get_class($this);
    }
}
