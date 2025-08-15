<?php

namespace App\Engines\Book\Converter\Modules;

use App\Enums\TagTypeEnum;
use App\Facades\Bookshelves;
use App\Models\Book;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Kiwilan\Ebook\Ebook;

class TagModule
{
    /**
     * Set Tags from Ebook.
     *
     * @return Collection<int, Tag>
     */
    public static function toCollection(Ebook $ebook): Collection
    {
        $self = new self;
        $items = collect([]);

        foreach ($ebook->getTags() as $key => $tag) {
            $model = $self->make($tag);

            if (! $model) {
                continue;
            }

            $isExists = Tag::where('name', $model->name)
                ->orWhere('slug', $model->slug)
                ->first();

            if (! $isExists) {
                $isExists = $model->createOrFirst($model->toArray());
            }
            $items->push($isExists);
        }

        return $items;
    }

    /**
     * Attach Tag to Book and define type from list of main tags.
     */
    // public static function make(string $tag): ?Tag
    // {
    //     $mainGenres = config('bookshelves.tags.genres_list');
    //     $tag = str_replace(' and ', ' & ', $tag);
    //     $tag = str_replace('-', ' ', $tag);
    //     $forbiddenTags = config('bookshelves.tags.forbidden');
    //     $convertedTags = config('bookshelves.tags.converted');

    //     foreach ($convertedTags as $key => $convertedTag) {
    //         if ($tag === $key) {
    //             $tag = $convertedTag;
    //         }
    //     }

    //     $model = null;

    //     if (strlen($tag) > 1 && strlen($tag) < 30 && ! in_array($tag, $forbiddenTags)) {
    //         $tag = strtolower($tag);
    //         $tag = ucfirst($tag);

    //         if (in_array($tag, $mainGenres)) {
    //             $model = Tag::findOrCreate($tag, TagTypeEnum::genre->value);
    //         } else {
    //             $model = Tag::findOrCreate($tag, TagTypeEnum::tag->value);
    //         }
    //     }

    //     return $model;
    // }

    public static function make(string $tag): ?Tag
    {
        $mainGenres = Bookshelves::tagsGenreList();
        $tag = str_replace(' and ', ' & ', $tag);
        $tag = str_replace('-', ' ', $tag);
        $forbiddenTags = Bookshelves::tagsForbiddenList();
        $convertedTags = Bookshelves::tagsConvertedList();

        foreach ($convertedTags as $key => $convertedTag) {
            if ($tag === $key) {
                $tag = $convertedTag;
            }
        }

        $model = null;

        if ($tag !== null && strlen($tag) > 1 && strlen($tag) < 30 && ! in_array($tag, $forbiddenTags)) {
            $tag = strtolower($tag);
            $tag = ucfirst($tag);

            $model = new Tag([
                'name' => $tag,
            ]);

            if (in_array($tag, $mainGenres)) {
                $model->type = TagTypeEnum::genre;
            } else {
                $model->type = TagTypeEnum::tag;
            }
        }

        return $model;
    }

    /**
     * @param  string[]  $tags
     * @return Collection<int, Tag>
     */
    public static function toTags(?array $tags): Collection
    {
        if (! $tags) {
            return collect([]);
        }

        $self = new self;
        $items = collect([]);

        foreach ($tags as $tag) {
            $model = $self->make($tag);

            if ($model) {
                $items->push($model);
            }
        }

        return $items;
    }
}
