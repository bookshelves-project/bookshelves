<?php

namespace App\Engines\Book;

use App\Engines\Book\File\BookFileItem;
use App\Engines\Converter\BookConverter;
use App\Facades\Bookshelves;
use App\Models\Book;
use App\Models\File;
use Kiwilan\Ebook\Ebook;
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
        protected bool $default = false,
        protected bool $isAudiobookAndBookExists = false,
    ) {}

    /**
     * Create a `Book` and relations from `BookFileItem`.
     */
    public static function make(File $file): ?self
    {
        $self = new self($file);
        try {
            $self->ebook = Ebook::read($file->path);
        } catch (\Throwable $th) {
            Journal::error("XML error on {$file->path}", [$th->getMessage()]);

            return null;
        }

        if (Bookshelves::analyzerDebug()) {
            $self->printFile($self->ebook?->toArray(), "{$self->ebook?->getFilename()}-parser.json");
        }

        $convert = BookConverter::make($self->ebook, $file);
        $self->book = $convert->book();
        $self->isAudiobookAndBookExists = $convert->isAudiobookAndBookExists();

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

    public function isAudiobookAndBookExists(): bool
    {
        return $this->isAudiobookAndBookExists;
    }

    private function printFile(mixed $file, string $name, bool $raw = false): bool
    {
        $base_path = storage_path('app/debug');
        if (! file_exists($base_path)) {
            mkdir($base_path, 0775, true);
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
