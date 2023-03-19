<?php

namespace App\Engines\Book\Parser\Parsers;

use App\Engines\Book\Parser\Modules\Extractor\Extractor;
use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use App\Engines\Book\Parser\Modules\Interface\XmlInterface;
use App\Engines\Book\Parser\Utils\XmlReader;
use App\Engines\Book\ParserEngine;
use Closure;
use File;
use Kiwilan\Steward\Utils\Console;
use RarArchive;
use RarEntry;
use ZipArchive;

/**
 * Parse archive to extract XML path and cover, implements `XmlInterface`.
 */
class ArchiveParser extends BookParser
{
    /** @var array<string, mixed> */
    protected array $archiveFiles = [];

    protected function __construct(
        protected ArchiveParserEnum $type = ArchiveParserEnum::zip,
        protected string $indexExtension = 'xml',
        protected bool $indexIsFound = false,
        protected ?string $indexContent = null,
        protected ?string $extracted = null,
    ) {
    }

    /**
     * Open Zip to find file with `extensionIndex`, convert it to `array` and parse it.
     */
    public static function make(ParserModule $module): ?self
    {
        $path = $module->file()->path();
        $extension = $module->file()->extension();

        $type = match ($extension) {
            'epub' => ArchiveParserEnum::zip,
            'cbz' => ArchiveParserEnum::zip,
            'cbr' => ArchiveParserEnum::rar,
            default => null,
        };

        if (! $type) {
            throw new \Exception("ArchiveParser {$extension} not supported");
        }

        if ($type === ArchiveParserEnum::rar && ! extension_loaded('rar')) {
            $console = Console::make();
            $console->print('.rar file: rar extension: is not installed', 'red');
            $console->print('Check this guide https://gist.github.com/ewilan-riviere/3f4efd752905abe24fd1cd44412d9db9', 'red');

            return null;
        }

        $self = new self($type);
        $self->setup($module);

        return $self;
    }

    /**
     * Set extension to search for index file.
     */
    public function setIndexExtension(string $indexExtension = 'xml'): self
    {
        $this->indexExtension = $indexExtension;

        return $this;
    }

    public function cover(): ?string
    {
        return $this->cover;
    }

    /**
     * Open archive.
     *
     * @param Closure(array $metadata): Extractor  $parser
     */
    public function parse(Closure $parser): self
    {
        $archive = $this->getArchive();

        $this->parseArchive($archive(), function (mixed $file, string $name, string $ext, mixed $archive) {
            $this->archiveFiles[] = $name;

            if ($ext === $this->indexExtension) {
                $this->indexIsFound = true;
                $this->indexContent = $this->extractFile($file, $name, $archive);
            }
        });

        $this->count = count($this->archiveFiles);
        $this->sortArchiveFiles();
        $this->metadata = $this->setMetadata();
        $this->metadata['count'] = $this->count;

        if (empty($this->metadata)) {
            $console = Console::make();
            $console->print('Metadata is empty', 'red');

            return $this;
        }

        $extractor = $parser($this->metadata);
        $this->cover = $this->extractCover($extractor, $archive);

        $archive()->close();

        return $this;
    }

    private function getArchive(): Closure
    {
        return match ($this->type) {
            ArchiveParserEnum::zip => function () {
                $archive = new ZipArchive();
                $archive->open($this->path);

                return $archive;
            },
            ArchiveParserEnum::rar => fn () => RarArchive::open($this->path),
        };
    }

    /**
     * Parse archive to find index file.
     *
     * @param Closure(mixed $file, string $name, string $ext, mixed $archive): void  $closure
     */
    private function parseArchive(ZipArchive|RarArchive $archive, ?Closure $closure = null): void
    {
        match ($this->type) {
            ArchiveParserEnum::zip => $this->parseZipFile($archive, $closure),
            ArchiveParserEnum::rar => $this->parseRarFile($archive, $closure),
        };
    }

    private function parseZipFile(ZipArchive $archive, ?Closure $closure = null)
    {
        for ($i = 0; $i < $archive->numFiles; $i++) {
            $file = $archive->statIndex($i);
            $name = $file['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);

            if ($closure) {
                $closure($file, $name, $ext, $archive);
            }
        }
    }

    private function parseRarFile(RarArchive $archive, Closure $closure = null)
    {
        foreach ($archive->getEntries() as $key => $entry) {
            if ($entry->isDirectory()) {
                continue;
            }

            $name = $entry->getName();
            $ext = pathinfo($name, PATHINFO_EXTENSION);

            if ($closure) {
                $closure($entry, $name, $ext, null);
            }
        }
    }

    private function extractFile(mixed $entry, string $name, mixed $archive = null): string
    {
        if ($this->type === ArchiveParserEnum::zip) {
            /** @var ZipArchive $archive */
            return $archive->getFromName($name);
        }

        if ($this->type === ArchiveParserEnum::rar) {
            $content = '';

            /** @var RarEntry $entry */
            $stream = $entry->getStream();

            // https://www.php.net/manual/en/rarentry.getstream.php
            while (! feof($stream)) {
                $buff = fread($stream, 8192);

                if ($buff !== false) {
                    $content .= $buff;
                }
            }

            return $content;
        }

        throw new \Exception('Unknown archive type');
    }

    private function checkImageFormat(string $ext): bool
    {
        foreach (self::IMAGE_FORMATS as $value) {
            if ($value === $ext) {
                return true;
            }
        }

        return false;
    }

    /**
     * Sort file list.
     */
    private function sortArchiveFiles()
    {
        natsort($this->archiveFiles);
        $this->archiveFiles = array_values($this->archiveFiles);
    }

    private function extractCover(Extractor $extractor, Closure $archive): ?string
    {
        if (! $extractor->cover()->isExists()) {
            return null;
        }

        $first = null;

        if ($extractor->cover()->isFirst()) {
            $images = array_filter($this->archiveFiles, function (string $file) use ($extractor) {
                $ext = pathinfo($file, PATHINFO_EXTENSION);

                if (in_array($ext, self::IMAGE_FORMATS, true)) {
                    return $file;
                }
            });
            $first = array_shift($images);
        }

        $this->parseArchive($archive(), function ($file, string $name, string $ext, mixed $archive) use ($extractor, $first) {
            if ($this->checkImageFormat($ext)) {
                if ($extractor->cover()->isFirst()) {
                    if ($first === $name) {
                        $this->extracted = $this->extractFile($file, $name, $archive);
                    }
                } else {
                    if ($extractor->cover()->name() === $name) {
                        $this->extracted = $this->extractFile($file, $name, $archive);
                    }
                }
            }
        });

        return base64_encode($this->extracted);
    }

    /**
     * Parse XML file.
     *
     * @return array<string, mixed>
     */
    private function setMetadata(): ?array
    {
        $console = Console::make();

        if (! $this->indexContent) {
            $console->print("{$this->indexExtension} is null, can't get {$this->module->file()->name()}", 'red');
            $console->newLine();

            return null;
        }

        if ($this->module->debug()) {
            ParserEngine::printFile($this->indexContent, "{$this->module->file()->name()}.{$this->indexExtension}", true);
        }

        return XmlReader::make($this->indexContent);
    }
}

enum ArchiveParserEnum: string
{
    case zip = 'zip';

    case rar = 'rar';
}
