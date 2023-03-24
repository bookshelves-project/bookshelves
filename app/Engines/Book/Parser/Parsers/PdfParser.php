<?php

namespace App\Engines\Book\Parser\Parsers;

use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use Closure;
use Illuminate\Support\Facades\File;
use Imagick;
use Kiwilan\Steward\Utils\Console;
use Smalot\PdfParser\Parser;

class PdfParser extends BookParser
{
    protected function __construct(
    ) {
    }

    /**
     * Parse file name to generate Book.
     *
     * Example: `La_Longue_Guerre.Terry_Pratchett&Stephen_Baxter.fr.La_Longue_Terre.2.Pocket.2017-02-09.9782266266284`
     * like `Original_Title.Author_Name&Other_Author_Name.Language.Serie_Title.Volume.Publisher.Date.Identifier`
     */
    public static function make(ParserModule $module): self
    {
        $self = new self();
        $self->setup($module);

        return $self;
    }

    public function extractCover(): self
    {
        if (config('bookshelves.pdf.cover')) {
            if (! extension_loaded('Imagick')) {
                $console = Console::make();
                $console->print(".pdf file: Imagick extension: is not installed (can't get cover)", 'red');
                $console->print('Check this guide https://gist.github.com/ewilan-riviere/3f4efd752905abe24fd1cd44412d9db9', 'red');

                throw new \Exception('Imagick extension is not installed');
            }

            $format = 'jpg';

            $imagick = new Imagick($this->path);
            $imagick->setFormat($format);

            $name = $this->module->file()->name();
            $path = public_path("storage/cache/{$name}.jpg");
            $imagick->writeImage($path);

            $this->cover = base64_encode(File::get($path));

            $imagick->clear();
            $imagick->destroy();
        }

        return $this;
    }

    public function cover(): ?string
    {
        return $this->cover;
    }

    /**
     * @param Closure(array $metadata): mixed  $closure
     */
    public function parse(Closure $closure): self
    {
        $pdf = new Parser();
        $doc = $pdf->parseFile($this->path);
        $metadata = $doc->getDetails();

        $closure($metadata);

        return $this;
    }
}
