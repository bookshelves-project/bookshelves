<?php

namespace App\Engines\Parser\Modules;

use App\Engines\Parser\Models\BookEntityAuthor;
use App\Engines\Parser\Models\BookEntityIdentifier;
use App\Engines\Parser\Modules\Interface\Module;
use App\Engines\Parser\Modules\Interface\ModuleInterface;
use App\Engines\Parser\Modules\Interface\XmlInterface;
use App\Engines\Parser\Parsers\ArchiveParser;
use App\Engines\ParserEngine;
use Kiwilan\Steward\Utils\Console;

class EpubModule extends Module implements ModuleInterface, XmlInterface
{
    public function __construct(
        public ?float $version = null,
    ) {
    }

    public static function make(ParserEngine $engine): ParserEngine|false
    {
        $archive = new ArchiveParser($engine, new EpubModule(), 'opf');

        return $archive->open();
    }

    public static function parse(ArchiveParser $archive_parser): ParserEngine
    {
        /** @var EpubModule */
        $module = $archive_parser->module;

        $module->metadata = $archive_parser->metadata;
        $module->version = 2.0;

        if ($module->metadata['@attributes'] && $version = $module->metadata['@attributes']['version']) {
            $module->version = floatval($version);
        }
        $module->engine = $archive_parser->engine;

        $is_supported = match ($module->version) {
            2.0 => $module->version2(),
            default => false,
        };

        if ($archive_parser->engine->debug()) {
            ParserEngine::printFile($module->metadata, "{$archive_parser->engine->fileName()}-metadata.json");
        }

        if (! $is_supported) {
            $console = Console::make();
            $console->print("EpubModule {$module->version} not supported");
        }

        return $archive_parser->engine;
    }

    private function version2(): static
    {
        $this->getCover();

        if ($this->metadata['metadata']) {
            $this->metadata = $this->metadata['metadata'];

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
                    BookEntityIdentifier::create([
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
     * - use BookEntityAuthor to get name and role
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
            $this->engine->tags = $subjects;
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
        if ($this->metadata['manifest'] && $items = $this->metadata['manifest']['item']) {
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
                $console = Console::make();
                $console->print('No cover from EpubModule', 'red');
                $console->newLine();
            }
        }

        return $this;
    }

    private function extractCreator(array $creator): BookEntityAuthor
    {
        return new BookEntityAuthor(
            name: $creator['@content'],
            role: $creator['@attributes']['role']
        );
    }
}
