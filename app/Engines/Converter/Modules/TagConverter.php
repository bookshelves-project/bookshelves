<?php

namespace App\Engines\Converter\Modules;

use App\Engines\Converter\Modules\Interface\ConverterInterface;
use App\Enums\TagTypeEnum;
use App\Models\Book;
use Illuminate\Support\Collection;
use Spatie\Tags\Tag;

class TagConverter implements ConverterInterface
{
    /**
     * Generate Tag[] for Book from ParserEngine.
     */
    public static function make(ConverterEngine $converter_engine): Collection
    {
        foreach ($converter_engine->parser_engine->tags as $key => $tag) {
            $tag_model = TagConverter::setTag($tag);

            if ($tag_model) {
                $converter_engine->book->attachTag($tag_model);
            }
        }
        $converter_engine->book->refresh();

        return $converter_engine->book->tags;
    }

    /**
     * Attach Tag to Book and define type from list of main tags.
     */
    public static function setTag(string $tag): ?Tag
    {
        $main_genres = config('bookshelves.tags.genres_list');
        $tag = str_replace(' and ', ' & ', $tag);
        $tag = str_replace('-', ' ', $tag);
        $forbidden_tags = config('bookshelves.tags.forbidden');
        $converted_tags = config('bookshelves.tags.converted');

        foreach ($converted_tags as $key => $converted_tag) {
            if ($tag === $key) {
                $tag = $converted_tag;
            }
        }

        $tag_model = null;

        if (strlen($tag) > 1 && strlen($tag) < 30 && ! in_array($tag, $forbidden_tags)) {
            $tag = strtolower($tag);
            $tag = ucfirst($tag);

            if (in_array($tag, $main_genres)) {
                $tag_model = Tag::findOrCreate($tag, TagTypeEnum::genre->value);
            } else {
                $tag_model = Tag::findOrCreate($tag, TagTypeEnum::tag->value);
            }
        }

        return $tag_model;
    }
}
