<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Models\BookCreator;
use App\Engines\ParserEngine\Models\BookIdentifier;
use App\Engines\ParserEngine\Parsers\XmlInterface;
use App\Engines\ParserEngine\Parsers\XmlParser;
use App\Services\ConsoleService;

class EpubModule implements XmlInterface
{
    public array $metadata = [];

    public function __construct(
        public ?array $xml_data = null,
        public ?float $version = null,
        public ?ParserEngine $engine = null,
    ) {
    }

    public static function create(ParserEngine $engine): ParserEngine|false
    {
        $xml = new XmlParser($engine, EpubModule::class, 'opf');
        $xml = $xml->openZip();

        return $xml->engine;
    }

    public static function parse(XmlParser $xml): ParserEngine
    {
        $module = new EpubModule();

        $module->xml_data = $xml->xml_data;
        $module->version = 2.0;

        if ($module->xml_data['@attributes'] && $version = $module->xml_data['@attributes']['version']) {
            $module->version = floatval($version);
        }
        $module->engine = $xml->engine;

        $is_supported = match ($module->version) {
            2.0 => $module->version2(),
            default => false,
        };

        if ($xml->engine->debug) {
            ParserEngine::printFile($module->xml_data, "{$xml->engine->file_name}-metadata.json");
        }
        if (! $is_supported) {
            ConsoleService::print("EpubModule {$module->version} not supported");
        }

        return $module->engine;
    }

    private function version2(): static
    {
        $this->getCover();

        if ($this->xml_data['metadata']) {
            $this->metadata = $this->xml_data['metadata'];

            $this->getRaw('dc:title', 'title');
            $this->getRaw('dc:description', 'description');
            $this->getRaw('dc:date', 'date');
            $this->getRaw('dc:publisher', 'publisher');
            $this->getRaw('dc:language', 'language');
            $this->getRaw('dc:rights', 'rights');
            $this->getSubjects('dc:subject');
            $this->getCreators('dc:creator');
            $this->getContributor('dc:contributor');
            $this->getIdentifiers('dc:identifier');
            $this->getCalibreMeta('meta');
        }

        return $this;
    }

    private function getRaw(string $extract_key, string $attribute): static
    {
        if (array_key_exists($extract_key, $this->metadata)) {
            $this->engine->{$attribute} = $this->metadata[$extract_key];
        }

        return $this;
    }

    /**
     * Get serie and volume.
     */
    private function getCalibreMeta(string $extract_key): ParserEngine
    {
        if (array_key_exists($extract_key, $this->metadata)) {
            foreach ($this->metadata[$extract_key] as $value) {
                if ($value['@attributes'] && $value['@attributes']['name'] && 'calibre:series' === $value['@attributes']['name']) {
                    $this->engine->serie = $value['@attributes']['content'];
                }
                if ($value['@attributes'] && $value['@attributes']['name'] && 'calibre:series_index' === $value['@attributes']['name']) {
                    $this->engine->volume = $value['@attributes']['content'];
                }
            }
        }

        return $this->engine;
    }

    /**
     * Get identifiers like ISBN.
     */
    private function getIdentifiers(string $extract_key): static
    {
        if (array_key_exists($extract_key, $this->metadata)) {
            $this->engine->identifiers = [];
            foreach ($this->metadata[$extract_key] as $identifier_value) {
                array_push(
                    $this->engine->identifiers,
                    BookIdentifier::create([
                        'id' => $identifier_value['@attributes']['scheme'],
                        'value' => $identifier_value['@content'],
                    ])
                );
            }
        }

        return $this;
    }

    /**
     * Get contributor.
     */
    private function getContributor(string $extract_key): static
    {
        if (array_key_exists($extract_key, $this->metadata)) {
            array_push($this->engine->contributor, $this->metadata[$extract_key]['@content']);
        }

        return $this;
    }

    /**
     * Get *creators* which will be authors
     * - use BookCreator to get name and role
     * - role can be 'aut' for author but it can be 'translator' for example.
     */
    private function getCreators(string $extract_key): static
    {
        if (array_key_exists($extract_key, $this->metadata)) {
            $creators = [];
            if (array_key_exists(0, $this->metadata[$extract_key])) {
                foreach ($this->metadata[$extract_key] as $creator_value) {
                    array_push($creators, $this->extractCreator($creator_value));
                }
            } else {
                array_push($creators, $this->extractCreator($this->metadata[$extract_key]));
            }
            $creators = array_map('unserialize', array_unique(array_map('serialize', $creators)));
            $this->engine->creators = $creators;
        }

        return $this;
    }

    private function getSubjects(string $extract_key): static
    {
        if (array_key_exists($extract_key, $this->metadata)) {
            $subjects = [];
            if (is_string($this->metadata[$extract_key])) {
                array_push($subjects, $this->metadata[$extract_key]);
            } else {
                foreach ($this->metadata[$extract_key] as $subject) {
                    array_push($subjects, $subject);
                }
            }
            $subjects = array_map('unserialize', array_unique(array_map('serialize', $subjects)));
            $this->engine->subjects = $subjects;
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
        if ($this->xml_data['manifest'] && $items = $this->xml_data['manifest']['item']) {
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
                ConsoleService::print('No cover from EpubModule');
            }
        }

        return $this;
    }

    private function extractCreator(array $creator): BookCreator
    {
        return new BookCreator(
            name: $creator['@content'],
            role: $creator['@attributes']['role']
        );
    }
}
