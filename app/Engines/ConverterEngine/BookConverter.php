<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ConverterEngine;
use App\Engines\ConverterEngine\Modules\AuthorConverter;
use App\Engines\ConverterEngine\Modules\BookIdentifierConverter;
use App\Engines\ConverterEngine\Modules\CoverConverter;
use App\Engines\ConverterEngine\Modules\LanguageConverter;
use App\Engines\ConverterEngine\Modules\PublisherConverter;
use App\Engines\ConverterEngine\Modules\SerieConverter;
use App\Engines\ConverterEngine\Modules\TagConverter;
use App\Engines\ConverterEngine\Modules\TypeConverter;
use App\Engines\ParserEngine;
use App\Models\Book;
use Illuminate\Support\Carbon;

/**
 * Create or improve a `Book` and relations from `ConverterEngine`.
 *
 * @property ConverterEngine $converter_engine use to create/improve `Book`.
 * @property ?Book           $book             `Book` instance.
 */
class BookConverter
{
    public function __construct(
        protected ConverterEngine $converter_engine,
        protected ?Book $book = null,
    ) {
    }

    /**
     * Generate Book from ParserEngine.
     */
    public static function make(ConverterEngine $converter_engine, ?Book $book = null): self
    {
        $book_converter = new BookConverter($converter_engine);

        if ($book) {
            $book_converter->checkBook();
        } else {
            $parser_engine = $converter_engine->parser_engine;
            $book = Book::firstOrCreate([
                'title' => $parser_engine->title,
                'slug' => $parser_engine->title_slug_lang,
                'slug_sort' => $parser_engine->title_serie_sort,
                'contributor' => implode(' ', $parser_engine->contributor),
                'released_on' => $parser_engine->released_on ?? null,
                'description' => $parser_engine->description,
                'rights' => $parser_engine->rights,
                'volume' => $parser_engine->serie ? $parser_engine->volume : null,
                'type' => $parser_engine->type,
                'page_count' => $parser_engine->page_count,
                'physical_path' => $parser_engine->file_path,
            ]);
        }
        $book_converter->book = $book;
        $book_converter->converter_engine->book = $book;

        return $book_converter;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function authors(): self
    {
        AuthorConverter::make($this->converter_engine);

        return $this;
    }

    public function bookIdentifiers(): self
    {
        BookIdentifierConverter::make($this->converter_engine);

        return $this;
    }

    public function cover(): self
    {
        CoverConverter::make($this->converter_engine);

        return $this;
    }

    public function language(): self
    {
        LanguageConverter::make($this->converter_engine);

        return $this;
    }

    public function publisher(): self
    {
        PublisherConverter::make($this->converter_engine);

        return $this;
    }

    public function serie(): self
    {
        SerieConverter::make($this->converter_engine);

        return $this;
    }

    public function tags(): self
    {
        TagConverter::make($this->converter_engine);

        return $this;
    }

    public function type(): self
    {
        TypeConverter::make($this->converter_engine);

        return $this;
    }

    public function save(): self
    {
        $this->book->save();

        return $this;
    }

    private function checkBook(): self
    {
        if (! $this->book) {
            return $this;
        }

        $parser_engine = $this->converter_engine->parser_engine;

        if (! $this->book->slug_sort && $parser_engine->serie && ! $this->book->serie) {
            $this->book->slug_sort = $parser_engine->title_serie_sort;
        }

        if (! $this->book->contributor) {
            $this->book->contributor = implode(' ', $parser_engine->contributor);
        }

        if (! $this->book->released_on) {
            $this->book->released_on = Carbon::parse($parser_engine->released_on);
        }

        if (! $this->book->rights) {
            $this->book->rights = $parser_engine->rights;
        }

        if (! $this->book->description) {
            $this->book->description = $parser_engine->description;
        }

        if (! $this->book->volume) {
            $this->book->volume = $parser_engine->serie ? $parser_engine->volume : null;
        }

        if (null === $this->book->type) {
            $this->book->type = $parser_engine->type;
        }

        return $this;
    }

    // public static function setDescription(Book $book, ?string $language_slug, ?string $description): Book
    // {
    //     if (null !== $description && null !== $language_slug && '' === $book->getTranslation('description', $language_slug)) {
    //         $book->setTranslation('description', $language_slug, $description);
    //     }

    //     return $book;
    // }
}
