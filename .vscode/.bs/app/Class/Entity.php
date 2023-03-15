<?php

namespace App\Class;

use App\Enums\BookTypeEnum;
use App\Models\Author;
use App\Models\Language;
use App\Models\Serie;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ReflectionClass;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property string $entity
 */
class Entity
{
    public ?string $meta_author;

    public ?string $slug;

    public ?string $show_link;

    public ?string $title;

    public ?BookTypeEnum $type;

    public ?string $relation;

    /** @var Author[] */
    public ?array $authors;

    public ?Serie $serie;

    public ?HasMany $books;

    public ?Language $language;

    public ?int $volume;

    public ?int $books_count;

    public ?Media $media_primary;

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

    protected function entity(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getEntity($this),
        );
    }
}
