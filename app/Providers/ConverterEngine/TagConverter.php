<?php

namespace App\Providers\ConverterEngine;

use App\Models\Book;
use Spatie\Tags\Tag;
use Illuminate\Support\Collection;
use App\Providers\ParserEngine\ParserEngine;

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
        $tags = $book->tags;

        return $tags;
    }

    /**
     * Attach Tag to Book and define type from list of main tags.
     */
    public static function tagRaw(string $tag, Book $book): Book
    {
        $main_genres = config('bookshelves.genres');
        $tag = str_replace(' and ', ' & ', $tag);
        $tag = str_replace('-', ' ', $tag);
        $forbidden_tags = config('bookshelves.forbidden_tags');
        $converted_tags = config('bookshelves.converted_tags');

        foreach ($converted_tags as $key => $converted_tag) {
            if ($tag === $key) {
                $tag = $converted_tag;
            }
        }

        if (strlen($tag) > 1 && strlen($tag) < 30 && ! in_array($tag, $forbidden_tags)) {
            $tag = strtolower($tag);
            $tag = ucfirst($tag);
            if (in_array($tag, $main_genres)) {
                $tag = Tag::findOrCreate($tag, 'genre');
            } else {
                $tag = Tag::findOrCreate($tag, 'tag');
            }

            $book->attachTag($tag);
        }

        return $book;
    }
}
