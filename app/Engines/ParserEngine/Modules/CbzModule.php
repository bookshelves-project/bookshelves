<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\BookCreator;
use App\Engines\ParserEngine\XmlParser;
use App\Services\ConsoleService;
use ZipArchive;

class CbzModule
{
    public function __construct(
        public ?array $xml = null,
        public ?string $type = null,
        public ?ParserEngine $engine = null,
    ) {
    }

    /**
     * Parse xml file as PHP XML file.
     */
    public static function create(ParserEngine $parser): ParserEngine|false
    {
        // Find and open EPUB as ZIP file
        $zip = new ZipArchive();
        $zip->open($parser->file_path);

        // Parse EPUB/ZIP file
        for ($i = 0; $i < $zip->numFiles; ++$i) {
            $file = $zip->statIndex($i);
            // Extract .xml file by it extension as string
            if (strpos($file['name'], '.xml')) {
                $xml = $zip->getFromName($file['name']);
            }
        }
        if (! isset($xml)) {
            ConsoleService::print("xmlModule: can't get XML");

            return false;
        }

        // If debug mode, create xml file into `debug`
        if ($parser->debug) {
            ParserEngine::printFile($xml, "{$parser->file_name}.xml", true);
        }

        // Transform xml to Array
        try {
            $parser = CbzModule::parse($xml, $parser);
        } catch (\Throwable $th) {
            ConsoleService::print(__METHOD__, $th);
        }

        // Parse EPUB/ZIP file
        // for ($i = 0; $i < $zip->numFiles; ++$i) {
        //     $file = $zip->statIndex($i);
        //     // If cover exist, extract it as string
        //     if ($parser->cover_name) {
        //         $cover = $zip->getFromName($parser->cover_name);
        //         $parser->cover_file = base64_encode($cover);
        //     }
        // }

        $zip->close();

        return $parser;
    }

    public static function parse(string $xml_file, ParserEngine $parser): ParserEngine
    {
        $xml = new XmlParser($xml_file);
        $module = new CbzModule();

        $module->xml = $xml->xml_to_array();
        $module->engine = $parser;

        $module->type = $module->xml['@root'];

        $is_supported = match ($module->type) {
            'ComicInfo' => $module->comicInfo(),
            default => false,
        };

        // If debug, create JSON file with xml data
        if ($parser->debug) {
            ParserEngine::printFile($module->xml, "{$parser->file_name}-metadata.json");
        }
        if (! $is_supported) {
            ConsoleService::print("xmlModule {$module->type} not supported");
        }

        return $parser;
    }

    private function comicInfo(): static
    {
        $this->getCover();

        if ($this->xml) {
            foreach ($this->xml as $node_key => $node) {
                $this->getRaw($node_key, $node, 'Title', 'title');
                $this->getRaw($node_key, $node, 'Series', 'serie');
                $this->getRaw($node_key, $node, 'Number', 'volume');
                $this->getCreators($node_key, $node, 'Writer', 'creators');
                $this->getRaw($node_key, $node, 'Publisher', 'publisher');
                $this->getRaw($node_key, $node, 'LanguageISO', 'language');
            }
        }

        return $this;
    }

    private function getRaw(string $node_key, mixed $node, string $extract_key, string $attribute): static
    {
        if ($node_key === $extract_key) {
            $this->engine->{$attribute} = $node;
        }

        return $this;
    }

    private function getCreators(string $node_key, mixed $node, string $extracted_key, string $attribute): static
    {
        if ($node_key === $extracted_key) {
            $creators = explode(',', $node);
            foreach ($creators as $creator) {
                $creator = new BookCreator(trim($creator), 'aut');
                array_push($this->engine->{$attribute}, $creator);
            }
        }

        return $this;
    }

    /**
     * Search if images exist.
     * - if cover is available from manifest
     * - define cover path into EPUB/ZIP file
     * - define extension of cover.
     */
    private function getCover(): static
    {
        if ($this->xml['manifest'] && $items = $this->xml['manifest']['item']) {
            $cover = null;

            foreach ($items as $node) {
                $attributes = $node['@attributes'] ?? null;

                $id = $attributes['id'] ?? null;
                $type = $attributes['media-type'] ?? null;
                $href = $attributes['href'] ?? null;

                if ($type && $id && $href && 'image/jpeg' === $type || 'image/png' === $type) {
                    // Check if cover exist in images.
                    if ('cover' === $id) {
                        $cover = $href;
                    } elseif (! $cover) {
                        /**
                         * If not, get first existing image
                         * If EPUB is dirty, it's possible for cover to have another name
                         * If you want to have right cover file, use a tool like Calibre to create new clean EPUB file.
                         */
                        $cover = $href;
                    }
                }
            }

            if (! empty($cover)) {
                $this->engine->cover_name = $cover;
                $this->engine->cover_extension = pathinfo($cover, PATHINFO_EXTENSION);
            } else {
                ConsoleService::print('No cover from OpfModule');
            }
        }

        return $this;
    }
}
