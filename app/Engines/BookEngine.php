<?php

namespace App\Engines;

use App\Engines\Book\BookFileItem;
use App\Engines\Book\ConverterEngine;
use App\Facades\Bookshelves;
use Illuminate\Support\Facades\File;
use Kiwilan\Ebook\Ebook;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BookEngine
{
    protected function __construct(
        protected Ebook $ebook,
        protected BookFileItem $file,
        protected ConverterEngine $converter,
    ) {
    }

    public static function make(BookFileItem $file): self
    {
        $ebook = Ebook::read($file->path());
        if (Bookshelves::analyzerDebug()) {
            BookEngine::printFile($ebook->toArray(), "{$ebook->getFilename()}-parser.json");
        }
        $converter = ConverterEngine::make($ebook, $file);

        return new self($ebook, $file, $converter);
    }

    public function ebook(): Ebook
    {
        return $this->ebook;
    }

    public function file(): BookFileItem
    {
        return $this->file;
    }

    public function converter(): ConverterEngine
    {
        return $this->converter;
    }

    public static function printFile(mixed $file, string $name, bool $raw = false): bool
    {
        try {
            $file = $raw
                ? $file
                : json_encode($file, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            return File::put(storage_path("app/debug/{$name}"), $file);
        } catch (\Throwable $th) {
            Journal::error(__METHOD__, [$th->getMessage()]);
        }

        return false;
    }
}
