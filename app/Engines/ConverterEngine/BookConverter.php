<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Enums\BookTypeEnum;
use App\Models\Book;
use App\Services\ConsoleService;
use File;
use Illuminate\Support\Carbon;
use Str;

class BookConverter
{
    /**
     * Generate Book from ParserEngine.
     */
    public static function create(ParserEngine $parser): Book
    {
        return Book::firstOrCreate([
            'title' => $parser->title,
            'slug' => $parser->title_slug_lang,
            'slug_sort' => $parser->title_serie_sort,
            'contributor' => implode(' ', $parser->contributor),
            'description' => $parser->description,
            'released_on' => $parser->released_on ?? null,
            'rights' => $parser->rights,
            'volume' => $parser->serie ? $parser->volume : null,
            'type' => $parser->type,
            'page_count' => $parser->page_count,
        ]);
    }

    public static function check(ParserEngine $parser, Book $book): Book
    {
        if (! $book->slug_sort && $parser->serie && ! $book->serie) {
            $book->slug_sort = $parser->title_serie_sort;
        }
        if (! $book->contributor) {
            $book->contributor = implode(' ', $parser->contributor);
        }
        if (! $book->description) {
            $book->description = $parser->description;
        }
        if (! $book->released_on) {
            $book->released_on = Carbon::parse($parser->released_on);
        }
        if (! $book->rights) {
            $book->rights = $parser->rights;
        }
        if (! $book->volume) {
            $book->volume = $parser->serie ? $parser->volume : null;
        }
        if (null === $book->type) {
            $book->type = $parser->type;
        }

        return $book;
    }
}
