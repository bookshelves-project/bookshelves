<?php

namespace App\Engines\Parser\Parsers;

use App\Engines\Parser\Modules\Interface\ParserModule;
use App\Engines\Parser\Modules\Interface\XmlInterface;
use App\Engines\ParserEngine;
use File;
use Kiwilan\Steward\Utils\Console;
use RarArchive;
use ZipArchive;

/**
 * Parse archive to extract XML path and cover, implements `XmlInterface`.
 */
class ArchiveParser
{
    public const IMAGE_FORMATS = ['jpg', 'jpeg'];

    /** @var array<string, mixed> */
    protected array $metadata = [];

    /** @var array<string, mixed> */
    protected array $zipFiles = [];

    protected function __construct(
        protected ParserModule&XmlInterface $module,
        protected string $extensionIndex = 'xml',
        protected ?string $xmlString = null,
        protected bool $findCover = false,
        protected bool $isRar = false,
    ) {
    }

    /**
     * Open Zip to find file with `extensionIndex`, convert it to `array` and parse it.
     */
    public static function make(ParserModule&XmlInterface $module): ?self
    {
        return new self($module);
    }

    public function setIsRar(bool $isRar = true): self
    {
        $this->isRar = $isRar;

        return $this;
    }

    public function setExtensionIndex(string $extensionIndex = 'xml'): self
    {
        $this->extensionIndex = $extensionIndex;

        return $this;
    }

    public function execute(): ParserModule
    {
        if ($this->isRar) {
            $this->openRar();
        } else {
            $this->openZip();
        }

        $this->module->setPageCount(count($this->zipFiles));

        return $this->module;
    }

    private function openRar(): ?self
    {
    //     if (! extension_loaded('rar')) {
    //         $console = Console::make();
    //         $console->print('.rar file: rar extension: is not installed', 'red');

    //         return null;
    //     }

    //     $zip = RarArchive::open($this->engine->filePath());
    //     $path = public_path('storage/cache');

    //     $zipFiles = [];

    //     foreach ($zip->getEntries() as $key => $entry) {
    //         $name = $entry->getName();
    //         $ext = pathinfo($name, PATHINFO_EXTENSION);

    //         if ($this->find_cover && $this->checkImageFormat($ext)) {
    //             $zipFiles[] = $name;
    //         }

    //         if ($ext === $this->extension_index) {
    //             $xmlPath = "{$path}/{$this->engine->fileName()}.{$ext}";
    //             $entry->extract($path, $xmlPath);

    //             $this->xmlString = File::get($xmlPath);
    //             File::delete($xmlPath);
    //         }
    //     }
    //     $this->sortFileList($zipFiles);

    //     $this->parseXml();

    //     if ($this->engine->coverName()) {
    //         foreach ($zip->getEntries() as $key => $entry) {
    //             if ($this->engine->coverName === $entry->getName()) {
    //                 $extension = explode('.', $entry->getName());
    //                 $extension = end($extension);
    //                 $coverPath = "{$path}/{$this->engine->fileName()}.{$extension}";
    //                 $entry->extract($path, $coverPath);

    //                 $cover = File::get($coverPath);
    //                 $this->engine->coverFile = base64_encode($cover);
    //                 File::delete($coverPath);
    //             }
    //         }
    //     }

    //     $zip->close();

        return $this;
    }

    private function openZip(): self
    {
        $zip = new ZipArchive();
        $zip->open($this->module->file()->path());

        $zipFiles = [];

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $file = $zip->statIndex($i);
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

            if ($this->findCover && $this->checkImageFormat($ext)) {
                $zipFiles[] = $file['name'];
            }

            if ($ext === $this->extensionIndex) {
                $this->xmlString = $zip->getFromName($file['name']);
            }
        }

        $this->zipFiles = $zipFiles;

        $this->sortFileList();

        $this->metadata = $this->parseXml();
        $this->module = $this->module->parse($this->metadata);

        if ($this->module->cover()?->name()) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $cover = $zip->getFromName($this->module->cover()->name());
                $this->module->setCoverFile(base64_encode($cover));
            }
        }

        $zip->close();

        return $this;
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
    private function sortFileList()
    {
        if ($this->findCover) {
            natsort($zipFiles);
            $this->zipFiles = array_values($zipFiles);

            if (count($this->zipFiles) > 0) {
                $this->module->setCoverName($this->zipFiles[0]);
            }
        }
    }

    /**
     * Parse XML file.
     *
     * @return array<string, mixed>|null
     */
    private function parseXml(): array
    {
        $console = Console::make();

        if (! $this->xmlString) {
            $console->print("{$this->extensionIndex} is null, can't get {$this->module->file()->name()}", 'red');
            $console->newLine();

            return null;
        }

        if ($this->module->debug()) {
            ParserEngine::printFile($this->xmlString, "{$this->module->file()->name()}.{$this->extensionIndex}", true);
        }

        return XmlParser::make($this->xmlString);
    }
}
