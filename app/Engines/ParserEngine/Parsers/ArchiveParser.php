<?php

namespace App\Engines\ParserEngine\Parsers;

use App\Engines\ParserEngine;
use App\Services\ConsoleService;
use File;
use RarArchive;
use Selective\Rar\RarFileReader;
use SplFileObject;
use ZipArchive;

/**
 * Parse XML string to array.
 */
class ArchiveParser
{
    public function __construct(
        public ?ParserEngine $engine,
        public ?string $module,
        public ?string $extension_index = 'xml',
        public ?array $xml_data = [],
        public ?array $zip_files_list = [],
        public ?string $xml_string = null,
        public ?bool $find_cover = false,
        public ?bool $is_rar = false,
    ) {
    }

    /**
     * Open Zip to find file with `$extension_index`, convert it to `array` and parse it. To use this method, the module have to implements `XmlInterface`.
     */
    public function open(): ParserEngine|false
    {
        if ($this->is_rar) {
            $this->rar();
        } else {
            $this->zip();
        }

        return $this->engine;
    }

    public function rar(): static|false
    {
        if (! extension_loaded('rar')) {
            ConsoleService::print('.rar file: rar extension: is not installed', 'red');

            return false;
        }
        $zip = RarArchive::open($this->engine->file_path);
        $path = public_path('storage/cache');

        $zip_files_list = [];
        foreach ($zip->getEntries() as $key => $entry) {
            $name = $entry->getName();
            $ext = pathinfo($name, PATHINFO_EXTENSION);

            if ($this->find_cover && 'jpg' === $ext) {
                array_push($zip_files_list, $name);
            }
            if ($ext === $this->extension_index) {
                $xml_path = "{$path}/{$this->engine->file_name}.{$ext}";
                $entry->extract($path, $xml_path);

                $this->xml_string = File::get($xml_path);
                File::delete($xml_path);
            }
        }
        $this->sortFileList($zip_files_list);

        $this->parseXml();

        if ($this->engine->cover_name) {
            foreach ($zip->getEntries() as $key => $entry) {
                if ($this->engine->cover_name === $entry->getName()) {
                    $cover_path = "{$path}/{$this->engine->file_name}.jpg";
                    $entry->extract($path, $cover_path);

                    $cover = File::get($cover_path);
                    $this->engine->cover_file = base64_encode($cover);
                    File::delete($cover_path);
                }
            }
        }

        $zip->close();

        return $this;
    }

    public function zip(): static|false
    {
        $zip = new ZipArchive();
        $zip->open($this->engine->file_path);

        $zip_files_list = [];
        for ($i = 0; $i < $zip->numFiles; ++$i) {
            $file = $zip->statIndex($i);
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

            if ($this->find_cover && 'jpg' === $ext) {
                array_push($zip_files_list, $file['name']);
            }
            if ($ext === $this->extension_index) {
                $this->xml_string = $zip->getFromName($file['name']);
            }
        }
        $this->sortFileList($zip_files_list);

        $this->parseXml();

        if ($this->engine->cover_name) {
            for ($i = 0; $i < $zip->numFiles; ++$i) {
                $cover = $zip->getFromName($this->engine->cover_name);
                $this->engine->cover_file = base64_encode($cover);
            }
        }

        $zip->close();

        return $this;
    }

    private function sortFileList(array $zip_files_list)
    {
        if ($this->find_cover) {
            natsort($zip_files_list);
            $this->zip_files_list = array_values($zip_files_list);
            if (sizeof($this->zip_files_list) > 0) {
                $this->engine->cover_name = $this->zip_files_list[0];
            }
        }
    }

    private function parseXml()
    {
        if ($this->xml_string) {
            $parser = XmlParser::create($this);
            $this->xml_data = $parser->xml_data;
            $this->engine = $parser->engine;
        }
    }
}
