<?php

namespace App\Traits;

use ReflectionClass;
use Str;

trait HasShowRoute
{
    protected $default_show_route_column = 'slug';

    public function getShowRouteColumn(): string
    {
        return $this->show_route_column ?? $this->default_show_route_column;
    }

    public function getRouteShowAttribute(): ?string
    {
        $instance = new $this();
        $class = new ReflectionClass($instance);
        $static = $class->getName();
        $route_name = Str::kebab($class->getShortName());
        $route_name = str_replace('-', '.', $route_name);
        $param_name = str_replace('.', '_', $route_name);

        return route("api.{$route_name}s.show", [
            "{$param_name}_{$this->getShowRouteColumn()}" => $this->{$this->getShowRouteColumn()},
        ]);
    }

    public function getMetaAttribute(): array
    {
        return [
            $this->getShowRouteColumn() => $this->{$this->getShowRouteColumn()},
            'show' => $this->route_show,
        ];
    }
}
