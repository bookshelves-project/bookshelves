<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Enums\TagTypeEnum;
use App\Models\Book;
use Illuminate\Support\Collection;
use Spatie\Tags\Tag;

class TagConverter
{
    /**
     * Generate Tag[] for Book from ParserEngine.
     */
    public static function create(ParserEngine $parser, Book $book): Collection
    {
        foreach ($parser->subjects as $key => $subject) {
            self::tagRaw($subject, $book);
        }
        $book->refresh();

        return $book->tags;
    }

    /**
     * Attach Tag to Book and define type from list of main tags.
     */
    public static function tagRaw(string $tag, Book $book): Book
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

        if (strlen($tag) > 1 && strlen($tag) < 30 && ! in_array($tag, $forbidden_tags)) {
            $tag = strtolower($tag);
            $tag = ucfirst($tag);
            if (in_array($tag, $main_genres)) {
                $tag = Tag::findOrCreate($tag, TagTypeEnum::genre->value);
            } else {
                $tag = Tag::findOrCreate($tag, TagTypeEnum::tag->value);
            }

            $book->attachTag($tag);
        }

        return $book;
    }
}
