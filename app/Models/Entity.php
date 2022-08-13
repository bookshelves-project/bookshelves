<?php

namespace App\Models;

use App\Enums\BookTypeEnum;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ReflectionClass;

class Entity
{
    public ?string $meta_author;

    public ?string $slug;

    public ?string $show_link;

    public ?string $title;

    public ?string $name;

    public ?BookTypeEnum $type;

    public ?string $relation;

    /** @var Author[] */
    public ?array $authors;

    public ?Serie $serie;

    public ?HasMany $books;

    public ?Language $language;

    public ?int $volume;

    public ?int $books_count;

    public ?string $cover_thumbnail;

    public ?string $cover_original;

    public ?string $cover_simple;

    public ?string $cover_color;

    public ?string $opds_link;

    public ?string $first_char;

    public static function getEntity(object $class): string
    {
        $class = new ReflectionClass($class);
        $class = $class->getShortName();

        return strtolower($class);
    }
}
