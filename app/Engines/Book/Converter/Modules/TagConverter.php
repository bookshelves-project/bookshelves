<?php

namespace App\Engines\Book\Converter\Modules;

use App\Enums\TagTypeEnum;
use App\Models\Book;
use Illuminate\Support\Collection;
use Kiwilan\Ebook\BookEntity;
use Spatie\Tags\Tag;

class TagConverter
{
    /**
     * Set Tags from BookEntity.
     *
     * @return Collection<int, Tag>
     */
    public static function toCollection(BookEntity $entity): Collection
    {
        $self = new self();
        $items = collect([]);

        foreach ($entity->tags() as $key => $tag) {
            $model = $self->make($tag);

            if ($model) {
                $items->push($model);
            }
        }

        return $items;
    }

    /**
     * Attach Tag to Book and define type from list of main tags.
     */
    public static function make(string $tag): ?Tag
    {
        $mainGenres = config('bookshelves.tags.genres_list');
        $tag = str_replace(' and ', ' & ', $tag);
        $tag = str_replace('-', ' ', $tag);
        $forbiddenTags = config('bookshelves.tags.forbidden');
        $convertedTags = config('bookshelves.tags.converted');

        foreach ($convertedTags as $key => $convertedTag) {
            if ($tag === $key) {
                $tag = $convertedTag;
            }
        }

        $model = null;

        if (strlen($tag) > 1 && strlen($tag) < 30 && ! in_array($tag, $forbiddenTags)) {
            $tag = strtolower($tag);
            $tag = ucfirst($tag);

            if (in_array($tag, $mainGenres)) {
                $model = Tag::findOrCreate($tag, TagTypeEnum::genre->value);
            } else {
                $model = Tag::findOrCreate($tag, TagTypeEnum::tag->value);
            }
        }

        return $model;
    }
}
