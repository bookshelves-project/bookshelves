<?php

namespace App\Traits;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Closure;
use ReflectionClass;

/**
 * @property string $entity
 * @property array $meta
 * @property string $opds_link
 */
trait IsEntity
{
    public function initializeIsEntity()
    {
        $this->appends[] = 'entity';
        $this->appends[] = 'meta_route';
    }

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

    public function getMetaRouteAttribute(): ?string
    {
        /** @var Author|Book|Serie|mixed */
        $instance = $this;
        if ($instance instanceof Author) {
            return route('authors.show', [
                'author_slug' => $this->slug,
            ]);
        }

        if ($instance instanceof Book) {
            return route("{$this->type->value}s.show", [
                'book_slug' => $this->slug,
            ]);
        }

        if ($instance instanceof Serie) {
            return route("series.{$this->type->value}s.show", [
                'serie_slug' => $this->slug,
            ]);
        }

        return route('home');
    }
}
