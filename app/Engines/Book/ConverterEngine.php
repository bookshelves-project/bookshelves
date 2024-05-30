<?php

namespace App\Engines\Book;

use App\Engines\Book\Converter\BookConverter;
use App\Engines\Book\Converter\Modules\AuthorModule;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Ebook\Enums\EbookFormatEnum;
use Kiwilan\LaravelNotifier\Facades\Journal;

/**
 * Create a `Book` and relations.
 */
class ConverterEngine
{
    protected function __construct(
        protected Ebook $ebook,
        protected BookFileItem $file,
        protected ?Book $book = null,
        protected bool $isExist = false,
        protected bool $default = false
    ) {
    }

    /**
     * Create a `Book::class` and relations from `Ebook::class`.
     */
    public static function make(Ebook $ebook, BookFileItem $file, bool $default = false): ?ConverterEngine
    {
        $self = new self($ebook, $file);
        $self->default = $default;

        // if ($ebook->getFormat() === EbookFormatEnum::AUDIOBOOK) {
        //     $converter = BookConverter::make($self->ebook, $file->library(), $self->book);
        // } else {
        //     $self->book = $self->retrieveBook();
        //     if (! $self->book) {
        //         $converter = BookConverter::make($self->ebook, $file->library(), $self->book);
        //         $self->book = $converter->book();
        //     }
        // }

        return $self;
    }

    public function ebook(): Ebook
    {
        return $this->ebook;
    }

    public function book(): ?Book
    {
        return $this->book;
    }

    public function isExist(): bool
    {
        return $this->isExist;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }

    private function retrieveBook(): ?Book
    {
        $book = null;
        $names = [];

        foreach ($this->ebook->getAuthors() as $author) {
            $author = AuthorModule::make($author);
            $names[] = $author->name();
        }

        if (! $this->ebook->getTitle()) {
            Journal::warning("BookConverter: Title is empty for {$this->ebook->getPath()}", [
                'ebook' => $this->ebook->toArray(),
            ]);

            return null;
        }

        if (! $this->ebook->getMetaTitle()) {
            Journal::warning("BookConverter: MetaTitle is empty for {$this->ebook->getTitle()}", [
                'ebook' => $this->ebook->toArray(),
            ]);
        }

        $book = Book::query()
            ->where('slug', $this->ebook->getMetaTitle()?->getSlug());

        if (! empty($names)) {
            $book = $book->whereHas(
                'authors',
                fn (Builder $query) => $query->whereIn('name', $names)
            );
        }

        $book = $book->where('extension', $this->ebook->getExtension())->first();

        if ($book) {
            $this->isExist = true;
        }

        return $book;
    }
}
