<?php

namespace App\Engines;

use App\Engines\Book\BookFileItem;
use App\Engines\Book\ConverterEngine;
use Illuminate\Support\Facades\Storage;
use Kiwilan\Ebook\Ebook;
use Kiwilan\HttpPool\Utils\PrintConsole;

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
        if (config('bookshelves.analyzer.debug')) {
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
        $console = PrintConsole::make();

        try {
            $file = $raw
                ? $file
                : json_encode($file, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            return Storage::disk('public')->put("/debug/{$name}", $file);
        } catch (\Throwable $th) {
            $console->print(__METHOD__, $th);
        }

        return false;
    }
}
