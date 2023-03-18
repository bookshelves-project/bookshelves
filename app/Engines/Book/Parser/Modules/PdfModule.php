<?php

namespace App\Engines\Book\Parser\Modules;

use App\Engines\Book\Parser\Models\BookEntityAuthor;
use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use App\Engines\Book\Parser\Modules\Interface\ParserModuleInterface;
use App\Engines\Book\Parser\Parsers\PdfParser;
use App\Engines\Book\ParserEngine;
use Illuminate\Support\Facades\File;
use Imagick;
use Smalot\PdfParser\Parser;

/**
 * Parse PDF to extract cover with `ImageMagick` (if installed) and metadata.
 */
class PdfModule extends ParserModule implements ParserModuleInterface
{
    public function __construct(
    ) {
    }

    public static function make(ParserEngine $parser, bool $debug = false): ParserModule
    {
        $self = ParserModule::create($parser, self::class, $debug);

        return PdfParser::make($self)
            ->execute()
        ;
    }

    public function parse(array $metadata): ParserModule
    {
        if (config('bookshelves.pdf.cover')) {
            $this->extractCover();
        }

        if (config('bookshelves.pdf.metadata')) {
            $this->setMetadata();
        }

        return $this;
    }

    private function extractCover(): self
    {
        if (! extension_loaded('Imagick')) {
            $this->console->print(".pdf file: Imagick extension: is not installed (can't get cover)", 'red');

            return $this;
        }

        $format = 'jpg';

        $imagick = new Imagick($this->file()->path().'[0]');
        $imagick->setFormat($format);

        $name = $this->file()->name();
        $path = public_path("storage/cache/{$name}.jpg");
        $imagick->writeImage($path);

        $this->setCover();
        $this->setCoverFile(base64_encode(File::get($path)));

        $imagick->clear();
        $imagick->destroy();

        return $this;
    }

    private function setMetadata(): static
    {
        $pdf_parser = new Parser();
        $pdf = $pdf_parser->parseFile($this->file()->path());

        $this->metadata = $pdf->getDetails();

        $this->title = $this->extract('Title');
        $this->authors = $this->setAuthors();
        $this->description = $this->extract('Subject');
        $this->publisher = $this->extract('Producer');
        $this->tags = $this->setTags();
        $this->date = $this->extract('CreationDate');
        $this->pageCount = $this->extract('Pages');

        return $this;
    }

    private function extract(string $key): mixed
    {
        if (! array_key_exists($key, $this->metadata)) {
            return null;
        }

        $value = $this->metadata[$key];

        if (is_array($value)) {
            $value = reset($value);
        }

        return $value;
    }

    /**
     * @return BookEntityAuthor[]
     */
    private function setAuthors(): array
    {
        $current = $this->extract('Creator');

        if (! $current) {
            return [];
        }

        $list = [];
        $authors[] = $current;

        if (str_contains($current, ',')) {
            $authors = explode(',', $current);
        }

        if (str_contains($current, '&')) {
            $authors = explode('&', $current);
        }

        foreach ($authors as $author) {
            $list[] = new BookEntityAuthor($author, 'aut');
        }

        return $list;
    }

    /**
     * @return string[]
     */
    private function setTags(): array
    {
        $keywords = $this->extract('Keywords');

        if (! $keywords) {
            return [];
        }

        $subjects[] = $keywords;

        if (str_contains($keywords, ',')) {
            $subjects = explode(',', $keywords);
        }

        if (str_contains($keywords, '&')) {
            $subjects = explode('&', $keywords);
        }

        return $subjects;
    }
}
