<?php

namespace App\Engines;

use App\Engines\ConverterEngine\AuthorConverter;
use App\Engines\ConverterEngine\BookConverter;
use App\Engines\ConverterEngine\BookIdentifierConverter;
use App\Engines\ConverterEngine\CoverConverter;
use App\Engines\ConverterEngine\LanguageConverter;
use App\Engines\ConverterEngine\PublisherConverter;
use App\Engines\ConverterEngine\SerieConverter;
use App\Engines\ConverterEngine\TagConverter;
use App\Engines\ConverterEngine\TypeConverter;
use App\Engines\ParserEngine\Models\BookCreator;
use App\Enums\BookFormatEnum;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;

class ConverterEngine
{
    /**
     * Convert ParserEngine into Book and relations.
     * Rejected if Book slug exist.
     */
    public static function convert(?ParserEngine $parser, ?bool $default = false): Book|false
    {
        if ($parser) {
            $book = ConverterEngine::bookIfExist($parser);

            if ($book) {
                $book = BookConverter::check($parser, $book);
                ConverterEngine::setBookData($parser, $book, $default);
            } else {
                $book = BookConverter::create($parser);
                ConverterEngine::setBookData($parser, $book, $default);
            }
        }

        return false;
    }

    public static function setBookData(ParserEngine $parser, Book $book, bool $default): Book
    {
        AuthorConverter::generate($parser, $book);
        TagConverter::create($parser, $book);
        PublisherConverter::create($parser, $book);
        LanguageConverter::create($parser, $book);
        SerieConverter::create($parser, $book);
        BookIdentifierConverter::create($parser, $book);

        if (! $default && ! $book->cover_book) {
            $book = CoverConverter::create($parser, $book);
        }

        ConverterEngine::convertFormat($parser, $book);

        $book->save();

        return $book;
    }

    public static function convertFormat(ParserEngine $parser, Book|false $book)
    {
        if ($book) {
            TypeConverter::convert($parser, $book);
        }
    }

    public static function bookIfExist(?ParserEngine $parser): Book|false
    {
        if ($parser) {
            $authors_name = [];
            /** @var BookCreator $creator */
            foreach ($parser->creators as $creator) {
                $author = AuthorConverter::create($creator);
                array_push($authors_name, "{$author->firstname} {$author->lastname}");
                array_push($authors_name, "{$author->lastname} {$author->firstname}");
            }

            $book = Book::whereSlug($parser->title_slug_lang)
                ->whereHas(
                    'authors',
                    fn (Builder $query) => $query->whereIn('name', $authors_name)
                )
                ->whereType($parser->type)
                ->first()
            ;

            return null !== $book ? $book : false;
        }

        return false;
    }
}
