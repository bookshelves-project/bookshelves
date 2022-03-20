<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Enums\BookTypeEnum;
use App\Models\Book;
use App\Services\ConsoleService;
use File;
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
            'volume' => $parser->volume > 0 ? $parser->volume : null,
            'type' => $parser->type,
        ]);
    }
}
