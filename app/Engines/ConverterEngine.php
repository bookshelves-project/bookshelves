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
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;

class ConverterEngine
{
    public function __construct(
        public ParserEngine $parser,
        public ?Book $book = null,
        public ?bool $default = false
    ) {
    }

    /**
     * Convert ParserEngine into Book and relations.
     * Rejected if Book slug exist.
     */
    public static function create(?ParserEngine $parser, ?bool $default = false): Book|false
    {
        $converter = new ConverterEngine($parser);
        $converter->default = $default;
        if ($parser) {
            $book_exist = $converter->bookIfExist();

            if ($book_exist) {
                $converter->book = BookConverter::check($converter->parser, $book_exist);
                $converter->setRelations();
            } else {
                $converter->book = BookConverter::create($converter->parser);
                $converter->setRelations();
            }
        }

        return false;
    }

    public function setRelations(): Book
    {
        AuthorConverter::create($this);
        TagConverter::create($this);
        PublisherConverter::create($this);
        LanguageConverter::create($this);
        SerieConverter::create($this);
        BookIdentifierConverter::create($this);
        CoverConverter::create($this);
        TypeConverter::create($this);

        $this->book->save();

        return $this->book;
    }

    public function bookIfExist(): Book|false
    {
        $authors_name = [];
        /** @var BookCreator $creator */
        foreach ($this->parser->creators as $creator) {
            $author = AuthorConverter::convert($creator);
            array_push($authors_name, "{$author->firstname} {$author->lastname}");
            array_push($authors_name, "{$author->lastname} {$author->firstname}");
        }

        $book = Book::whereSlug($this->parser->title_slug_lang);
        if (! empty($authors_name)) {
            $book = $book->whereHas(
                'authors',
                fn (Builder $query) => $query->whereIn('name', $authors_name)
            );
        }
        $book = $book->whereType($this->parser->type)
            ->first()
        ;

        return null !== $book ? $book : false;
    }
}
