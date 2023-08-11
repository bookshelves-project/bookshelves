<?php

namespace App\Engines;

use App\Engines\Book\BookFileReader;
use App\Engines\Book\ConverterEngine;
use Illuminate\Support\Facades\Storage;
use Kiwilan\Ebook\Ebook;
use Kiwilan\HttpPool\Utils\PrintConsole;

class BookEngine
{
    protected function __construct(
        protected Ebook $ebook,
        protected BookFileReader $file,
        protected ConverterEngine $converter,
    ) {
    }

    public static function make(BookFileReader $file, bool $verbose = false, bool $default = false): self
    {
        $ebook = Ebook::read($file->path());

        if ($verbose) {
            BookEngine::verbose($ebook);
        }

        $converter = ConverterEngine::make($ebook, $file, $default);

        return new self($ebook, $file, $converter);
    }

    public function ebook(): Ebook
    {
        return $this->ebook;
    }

    public function file(): BookFileReader
    {
        return $this->file;
    }

    public function converter(): ConverterEngine
    {
        return $this->converter;
    }

    private static function verbose(Ebook $ebook): void
    {
        $console = PrintConsole::make();
        $console->print("{$ebook->getTitle()}");
        BookEngine::printFile($ebook->toArray(), "{$ebook->getFilename()}-parser.json");
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
