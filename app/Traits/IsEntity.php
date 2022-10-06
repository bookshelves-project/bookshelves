<?php

namespace App\Traits;

use App\Models\Author;
use Closure;
use ReflectionClass;

trait IsEntity
{
    public function getEntityAttribute(): string
    {
        return $this->getEntity();
    }

    public function getEntity(): string
    {
        $class = new ReflectionClass($this);
        $short_name = $class->getShortName();

        return strtolower($short_name);
    }

    public function getShowRouteEntity(): string
    {
        $entity = $this->getEntity();
        $route = null;
        if ($this instanceof Author) {
            $route = route("api.{$entity}s.show", [
                "{$entity}_slug" => $this->slug,
            ]);
        } else {
            $route = route("api.{$entity}s.show", [
                'author_slug' => $this->meta_author,
                "{$entity}_slug" => $this->slug,
            ]);
        }

        return $route;
    }

    public function isAuthorEntity(Closure $isAuthor, Closure $isNotAuthor)
    {
        if ($this instanceof Author) {
            return $isAuthor;
        }
        return $isNotAuthor;
    }

    public function getOpdsLinkAttribute(): string
    {
        $entity = $this->getEntity();
        $route = null;
        $route_name = "opds.{$entity}s.show";
        $version = '1.2';
        if ($this instanceof Author) {
            $route = route($route_name, [
                'version' => $version,
                'author' => $this->slug,
            ]);
        } else {
            $route = route($route_name, [
                'version' => $version,
                'author' => $this->meta_author,
                $entity => $this->slug,
            ]);
        }

        return $route;
    }

    public function getMetaAttribute(): array
    {
        $meta = [
            'entity' => $this->getEntity(),
            'show' => $this->getShowRouteEntity(),
            'slug' => $this->slug,
        ];

        if (! $this instanceof Author) {
            $meta['author'] = $this->meta_author;
        } else {
            $meta['books'] = route('api.authors.show.books', [
                'author_slug' => $this->slug,
            ]);
            $meta['series'] = route('api.authors.show.series', [
                'author_slug' => $this->slug,
            ]);
        }

        return $meta;
    }
}
