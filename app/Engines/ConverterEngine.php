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
use App\Models\Book;
use Illuminate\Contracts\Database\Eloquent\Builder;

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
            ConverterEngine::convertFormat($parser, $book);
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

                ConverterEngine::convertFormat($parser, $book);

                $book->save();

                return $book;
            }
        }

        return false;
    }

    public static function convertFormat(ParserEngine $parser, Book|false $book)
    {
        if ($book) {
            match ($parser->format) {
                BookFormatEnum::cbz => TypeConverter::cbz($book, $parser->file_path),
                BookFormatEnum::epub => TypeConverter::epub($book, $parser->file_path),
                BookFormatEnum::pdf => TypeConverter::pdf($book, $parser->file_path),
                default => false,
            };
        }
    }

    public static function bookIfExist(?ParserEngine $parser): Book|bool
    {
        if ($parser) {
            $book = Book::whereSlug($parser->title_slug_lang)
                ->whereRelation('authors', function (Builder $builder) use ($parser) {
                    $authors_name = [];
                    /** @var BookCreator $creator */
                    foreach ($parser->creators as $creator) {
                        $author = AuthorConverter::create($creator);
                        array_push($authors_name, "{$author->firstname} {$author->lastname}");
                        array_push($authors_name, "{$author->lastname} {$author->firstname}");
                    }
                    return $builder->whereIn('name', $authors_name);
                })
                ->whereType($parser->type)
                ->first()
            ;

            return null !== $book ? $book : false;
        }

        return false;
    }
}
