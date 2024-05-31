<?php

namespace App\Engines\Book;

use App\Engines\Book\Converter\BookConverter;
use App\Engines\Book\Converter\Modules\AuthorModule;
use App\Engines\Book\File\BookFileItem;
use App\Facades\Bookshelves;
use App\Models\Book;
use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Ebook\Enums\EbookFormatEnum;
use Kiwilan\LaravelNotifier\Facades\Journal;

/**
 * Create a `Book` and relations.
 */
class BookEngine
{
    protected function __construct(
        protected File $file,
        protected ?Ebook $ebook = null,
        protected ?Book $book = null,
        protected bool $isExist = false,
        protected bool $default = false
    ) {
    }

    /**
     * Create a `Book` and relations from `BookFileItem`.
     */
    public static function make(File $file): ?self
    {
        $self = new self($file);
        $self->ebook = Ebook::read($file->path);

        if (Bookshelves::analyzerDebug()) {
            $self->printFile($self->ebook?->toArray(), "{$self->ebook?->getFilename()}-parser.json");
        }

        BookConverter::make($self->ebook, $file);

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

    public function ebook(): ?Ebook
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
            Journal::warning("BookEngine: Title is empty for {$this->ebook->getPath()}", [
                'ebook' => $this->ebook->toArray(),
            ]);

            return null;
        }

        if (! $this->ebook->getMetaTitle()) {
            Journal::warning("BookEngine: MetaTitle is empty for {$this->ebook->getTitle()}", [
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

    private function printFile(mixed $file, string $name, bool $raw = false): bool
    {
        $base_path = storage_path('app/debug');
        if (! file_exists($base_path)) {
            mkdir($base_path, 0755, true);
        }

        try {
            $file = $raw
                ? $file
                : json_encode($file, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            return file_put_contents("{$base_path}/{$name}", $file);
        } catch (\Throwable $th) {
            Journal::error(__METHOD__, [$th->getMessage()]);
        }

        return false;
    }
}
