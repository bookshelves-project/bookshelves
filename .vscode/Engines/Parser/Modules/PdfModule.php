<?php

namespace App\Engines\Parser\Modules;

use App\Engines\Parser\Models\BookEntityAuthor;
use App\Engines\Parser\Modules\Interface\Module;
use App\Engines\Parser\Modules\Interface\ModuleInterface;
use App\Engines\ParserEngine;
use DateTime;
use Illuminate\Support\Facades\File;
use Imagick;
use Kiwilan\Steward\Utils\Console;
use Smalot\PdfParser\Parser;

/**
 * Parse PDF to extract cover with `ImageMagick` (if installed) and metadata.
 */
class PdfModule extends Module implements ModuleInterface
{
    public function __construct(
        public ?string $title = null,
        public ?string $creator = null,
        public ?string $author = null,
        public ?string $subject = null,
        public ?string $producer = null,
        public ?string $keywords = null,
        public ?DateTime $creation_date = null,
        public ?int $pages = 0,
    ) {
    }

    public static function make(ParserEngine $parser): ParserEngine|false
    {
        $module = new PdfModule();
        $module->engine = $parser;

        if (config('bookshelves.pdf.cover')) {
            $module = $module->getCover();
        }

        if (config('bookshelves.pdf.metadata')) {
            $module = $module->getMetadata();
        }

        return $parser;
    }

    private function getCover(): static
    {
        if (! extension_loaded('Imagick')) {
            $console = Console::make();
            $console->print(".pdf file: Imagick extension: is not installed (can't get cover)", 'red');
        } else {
            $format = 'jpg';

            $imagick = new Imagick($this->engine->filePath().'[0]');
            $imagick->setFormat($format);

            $name = $this->engine->fileName();
            $path = public_path("storage/cache/{$name}.jpg");
            $imagick->writeImage($path);
            $this->engine->cover_file = base64_encode(File::get($path));
            $imagick->clear();
            $imagick->destroy();
        }

        return $this;
    }

    private function getMetadata(): static
    {
        $pdf_parser = new Parser();
        $pdf = $pdf_parser->parseFile($this->engine->filePath());

        $this->metadata = $pdf->getDetails();

        $this->title = $this->checkKey('Title');
        $this->creator = $this->checkKey('Creator');
        $this->subject = $this->checkKey('Subject');
        $this->author = $this->checkKey('Author');
        $this->producer = $this->checkKey('Producer');
        $this->keywords = $this->checkKey('Keywords');
        $this->creation_date = new DateTime($this->checkKey('CreationDate'));
        $this->pages = $this->checkKey('Pages');

        $this->engine->title = $this->title;
        $this->engine->description = $this->subject;
        $this->engine->creators = $this->getCreators();
        $this->engine->publisher = $this->producer;
        $this->engine->tags = $this->getSubjects();
        $this->engine->released_on = $this->creation_date;
        $this->engine->page_count = $this->pages;

        return $this;
    }

    private function checkKey(string $key): mixed
    {
        $value = null;

        if (array_key_exists($key, $this->metadata)) {
            $value = $this->metadata[$key];

            if (is_array($value)) {
                $value = reset($value);
            }
        }

        return $value;
    }

    /**
     * @return BookEntityAuthor[]
     */
    private function getCreators()
    {
        $list = [];

        if (null !== $this->author) {
            $authors = [];
            array_push($authors, $this->author);

            if (str_contains($this->author, ',')) {
                $authors = explode(',', $this->author);
            }

            if (str_contains($this->author, '&')) {
                $authors = explode('&', $this->author);
            }

            foreach ($authors as $author) {
                array_push($list, new BookEntityAuthor($author, 'aut'));
            }
        }

        return $list;
    }

    /**
     * @return string[]
     */
    private function getSubjects()
    {
        $subjects = [];

        if (null !== $this->keywords) {
            array_push($subjects, $this->keywords);

            if (str_contains($this->keywords, ',')) {
                $subjects = explode(',', $this->keywords);
            }

            if (str_contains($this->keywords, '&')) {
                $subjects = explode('&', $this->keywords);
            }
        }

        return $subjects;
    }
}
