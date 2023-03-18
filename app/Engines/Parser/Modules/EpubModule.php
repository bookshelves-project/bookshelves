<?php

namespace App\Engines\Parser\Modules;

use App\Engines\Parser\Models\BookEntityAuthor;
use App\Engines\Parser\Models\BookEntityIdentifier;
use App\Engines\Parser\Modules\Interface\ParserModule;
use App\Engines\Parser\Modules\Interface\ParserModuleInterface;
use App\Engines\Parser\Parsers\ArchiveParser;
use App\Engines\ParserEngine;

class EpubModule extends ParserModule implements ParserModuleInterface
{
    public function __construct(
        protected float $version = 2.0,
    ) {
    }

    public static function make(ParserEngine $parser, bool $debug = false): ParserModule
    {
        $self = ParserModule::create($parser, self::class, $debug);

        return ArchiveParser::make($self)
            ->setExtensionIndex('opf')
            ->execute()
        ;
    }

    public function parse(array $metadata): self
    {
        $this->metadata = $metadata;

        if ($this->metadata['@attributes'] && $version = $this->metadata['@attributes']['version']) {
            $this->version = floatval($version);
        }

        $isSupported = match ($this->version) {
            2.0 => $this->version2(),
            default => false,
        };

        if ($this->debug) {
            ParserEngine::printFile($this->metadata, "{$this->file->name()}-metadata.json");
        }

        if (! $isSupported) {
            $this->console->print("EpubModule {$this->version} not supported", 'red');
            $this->console->newLine();
        }

        return $this;
    }

    private function version2(): self
    {
        $this->findCover();

        if (! array_key_exists('metadata', $this->metadata)) {
            throw new \Exception("EpubModule {$this->file->name()} metadata not supported");
        }

        $this->metadata = $this->metadata['metadata'];

        $this->title = $this->extract('dc:title');
        $this->description = $this->extract('dc:description');
        $this->date = $this->extract('dc:date');
        $this->publisher = $this->extract('dc:publisher');
        $this->language = $this->extract('dc:language');
        $this->rights = $this->extract('dc:rights');
        $this->tags = $this->setSubjects('dc:subject');
        $this->authors = $this->setCreators('dc:creator');
        $this->contributor = $this->setContributor('dc:contributor');
        $this->identifiers = $this->setIdentifiers('dc:identifier');
        $meta = $this->setCalibreMeta('meta');
        $this->serie = $meta['serie'];
        $this->volume = $meta['volume'];

        return $this;
    }

    private function extract(string $extractKey): ?string
    {
        if (array_key_exists($extractKey, $this->metadata)) {
            return $this->metadata[$extractKey];
        }

        return null;
    }

    /**
     * Get serie and volume.
     *
     * @return array<string, string|null>
     */
    private function setCalibreMeta(string $extractKey): array
    {
        $serie = null;
        $volume = null;

        if (array_key_exists($extractKey, $this->metadata)) {
            foreach ($this->metadata[$extractKey] as $value) {
                if ($value['@attributes'] && $value['@attributes']['name'] && 'calibre:series' === $value['@attributes']['name']) {
                    $serie = $value['@attributes']['content'];
                }

                if ($value['@attributes'] && $value['@attributes']['name'] && 'calibre:series_index' === $value['@attributes']['name']) {
                    $volume = $value['@attributes']['content'];
                }
            }
        }

        return [
            'serie' => $serie,
            'volume' => $volume,
        ];
    }

    /**
     * Get identifiers like ISBN.
     *
     * @return BookEntityIdentifier[]
     */
    private function setIdentifiers(string $extractKey): array
    {
        $identifiers = [];

        if (array_key_exists($extractKey, $this->metadata)) {
            foreach ($this->metadata[$extractKey] as $identifier_value) {
                array_push(
                    $identifiers,
                    BookEntityIdentifier::create([
                        'id' => $identifier_value['@attributes']['scheme'],
                        'value' => $identifier_value['@content'],
                    ])
                );
            }
        }

        return $identifiers;
    }

    /**
     * Get contributor.
     */
    private function setContributor(string $extractKey): string
    {
        $contributor = [];

        if (array_key_exists($extractKey, $this->metadata)) {
            array_push($contributor, $this->metadata[$extractKey]['@content']);
        }

        return implode(', ', $contributor);
    }

    /**
     * Get *creators* which will be authors
     * - use BookEntityAuthor to get name and role
     * - role can be 'aut' for author but it can be 'translator' for example.
     *
     * @return BookEntityAuthor[]
     */
    private function setCreators(string $extractKey): array
    {
        if (array_key_exists($extractKey, $this->metadata)) {
            $creators = [];

            if (array_key_exists(0, $this->metadata[$extractKey])) {
                foreach ($this->metadata[$extractKey] as $creator_value) {
                    array_push($creators, $this->extractCreator($creator_value));
                }
            } else {
                array_push($creators, $this->extractCreator($this->metadata[$extractKey]));
            }

            return array_map('unserialize', array_unique(array_map('serialize', $creators)));
        }

        return [];
    }

    /**
     * Extract subjects from metadata.
     *
     * @return string[]
     */
    private function setSubjects(string $extractKey): array
    {
        if (array_key_exists($extractKey, $this->metadata)) {
            $subjects = [];

            if (is_string($this->metadata[$extractKey])) {
                array_push($subjects, $this->metadata[$extractKey]);
            } else {
                foreach ($this->metadata[$extractKey] as $subject) {
                    array_push($subjects, $subject);
                }
            }

            return array_map('unserialize', array_unique(array_map('serialize', $subjects)));
        }

        return [];
    }

    /**
     * Search if images exist.
     * - if cover is available from manifest
     * - define cover path into EPUB/ZIP file
     * - define extension of cover.
     */
    private function findCover(): static
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
                $this->setCover();
                $this->setCoverName($cover);
                $this->setCoverExtension(pathinfo($cover, PATHINFO_EXTENSION));
            } else {
                $this->console->print('No cover from EpubModule', 'red');
                $this->console->newLine();
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
