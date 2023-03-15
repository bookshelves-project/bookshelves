<?php

namespace App\Engines;

use App\Engines\ConverterEngine\BookConverter;
use App\Engines\ConverterEngine\Modules\AuthorConverter;
use App\Engines\ParserEngine\Models\BookCreator;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;

/**
 * Create a `Book` and relations from `ParserEngine`.
 *
 * @property ParserEngine $parser_engine use to create/improve `Book` from `ParserEngine`.
 * @property ?Book        $book          `Book` instance.
 * @property bool         $default       use default media instead of create new.
 */
class ConverterEngine
{
    public function __construct(
        public ParserEngine $parser_engine,
        public ?Book $book = null,
        public ?bool $default = false
    ) {
    }

    /**
     * Create a `Book::class` and relations from `ParserEngine::class`.
     * Rejected if `ParserEngine::class` is `null`.
     */
    public static function make(?ParserEngine $parser_engine, bool $default = false): ?ConverterEngine
    {
        if (! $parser_engine) {
            return null;
        }

        $converter_engine = new ConverterEngine($parser_engine);
        $converter_engine->default = $default;

        $is_exist = $converter_engine->retrieveBook();

        $book_converter = BookConverter::make($converter_engine, $is_exist)
            ->authors()
            ->tags()
            ->publisher()
            ->language()
            ->serie()
            ->bookIdentifiers()
            ->cover()
            ->type()
            ->save()
        ;
        $converter_engine->book = $book_converter->getBook();

        return $converter_engine;
    }

    public function retrieveBook(): ?Book
    {
        $authors_name = [];
        /** @var BookCreator $creator */
        foreach ($this->parser_engine->creators as $creator) {
            $author = AuthorConverter::convert($creator);
            array_push($authors_name, "{$author->firstname} {$author->lastname}");
            array_push($authors_name, "{$author->lastname} {$author->firstname}");
        }

        $book = Book::whereSlug($this->parser_engine->title_slug_lang);
        if (! empty($authors_name)) {
            $book = $book->whereHas(
                'authors',
                fn (Builder $query) => $query->whereIn('name', $authors_name)
            );
        }
        return $book->whereType($this->parser_engine->type)
            ->first()
        ;
    }
}
