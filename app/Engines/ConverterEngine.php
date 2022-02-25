<?php

namespace App\Engines;

use App\Models\Book;
use App\Enums\BookFormatEnum;
use App\Engines\ConverterEngine\TagConverter;
use App\Engines\ConverterEngine\BookConverter;
use App\Engines\ConverterEngine\CoverConverter;
use App\Engines\ConverterEngine\SerieConverter;
use App\Engines\ConverterEngine\AuthorConverter;
use App\Engines\ConverterEngine\LanguageConverter;
use App\Engines\ConverterEngine\PublisherConverter;
use App\Engines\ConverterEngine\BookIdentifierConverter;

class ConverterEngine
{
    /**
     * Convert ParserEngine into Book and relations.
     * Rejected if Book slug exist.
     */
    public static function convert(ParserEngine $parser, bool $default): Book|false
    {
        $book = Book::whereSlug($parser->title_slug_lang)->first();
        if (! $book) {
            $book = BookConverter::create($parser);
            AuthorConverter::generate($parser, $book);
            TagConverter::create($parser, $book);
            PublisherConverter::create($parser, $book);
            LanguageConverter::create($parser, $book);
            SerieConverter::create($parser, $book);
            BookIdentifierConverter::create($parser, $book);

            if (! $default) {
                $book = CoverConverter::create($parser, $book);
            }

            match ($parser->format) {
                BookFormatEnum::epub => BookConverter::epub($book, $parser->file_path),
                default => false,
            };
            $book->save();

            return $book;
        }

        return false;
    }
}
