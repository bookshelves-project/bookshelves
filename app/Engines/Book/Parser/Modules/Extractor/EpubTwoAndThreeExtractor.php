<?php

namespace App\Engines\Book\Parser\Modules\Extractor;

use App\Engines\Book\Parser\Models\BookEntityAuthor;
use App\Engines\Book\Parser\Models\BookEntityCover;
use App\Engines\Book\Parser\Models\BookEntityIdentifier;
use Kiwilan\Steward\Utils\Console;

class EpubTwoAndThreeExtractor extends Extractor
{
    protected array $metadataRaw = [];

    /**
     * @param  array<string, mixed>  $metadata
     */
    public static function make(array $metadata): self
    {
        $self = new self();
        $self->metadata = $metadata;
        $self->parse();

        return $self;
    }

    private function parse(): self
    {
        $this->metadataRaw = $this->metadata;
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
        $this->cover = $this->setCover();

        return $this;
    }

    private function extract(string $extractKey): ?string
    {
        return array_key_exists($extractKey, $this->metadata)
            ? $this->metadata[$extractKey]
            : null;
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

        if (! array_key_exists($extractKey, $this->metadata)) {
            return [
                'serie' => null,
                'volume' => null,
            ];
        }

        foreach ($this->metadata[$extractKey] as $value) {
            if ($value['@attributes'] && $value['@attributes']['name'] && 'calibre:series' === $value['@attributes']['name']) {
                $serie = $value['@attributes']['content'];
            }

            if ($value['@attributes'] && $value['@attributes']['name'] && 'calibre:series_index' === $value['@attributes']['name']) {
                $volume = $value['@attributes']['content'];
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
        if (! array_key_exists($extractKey, $this->metadata)) {
            return [];
        }

        $identifiers = [];

        foreach ($this->metadata[$extractKey] as $identifier_value) {
            array_push(
                $identifiers,
                BookEntityIdentifier::create([
                    'id' => $identifier_value['@attributes']['scheme'],
                    'value' => $identifier_value['@content'],
                ])
            );
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
        if (! array_key_exists($extractKey, $this->metadata)) {
            return [];
        }

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

    private function extractCreator(array $creator): BookEntityAuthor
    {
        return new BookEntityAuthor(
            name: $creator['@content'],
            role: $creator['@attributes']['role']
        );
    }

    /**
     * Search if images exist.
     * - if cover is available from manifest
     * - define cover path into EPUB/ZIP file
     * - define extension of cover.
     */
    private function setCover(): BookEntityCover
    {
        $cover = new BookEntityCover();
        $manifestExists = array_key_exists('manifest', $this->metadataRaw);

        $items = array_key_exists('manifest', $this->metadataRaw)
            ? $this->metadataRaw['manifest']['item'] ?? null
            : null;

        if (! $manifestExists && ! $items) {
            return $cover;
        }

        $coverName = null;

        foreach ($items as $node) {
            $attributes = $node['@attributes'] ?? null;

            $id = $attributes['id'] ?? null;
            $type = $attributes['media-type'] ?? null;
            $href = $attributes['href'] ?? null;

            if (! $type && ! $id && ! $href) {
                continue;
            }

            if ('image/jpeg' !== $type && 'image/png' !== $type) {
                continue;
            }

            // Check if cover exist in images.
            if ('cover' === $id) {
                $coverName = $href;
            }

            if (! $coverName) {
                /**
                 * If not, get first existing image
                 * If EPUB is dirty, it's possible for cover to have another name
                 * If you want to have right cover file, use a tool like Calibre to create new clean EPUB file.
                 */
                $coverName = $href;
            }
        }

        if (empty($coverName)) {
            $console = Console::make();
            $console->print('No cover from EpubModule', 'red');
            $console->newLine();

            return $cover;
        }

        $cover->setIsExists();
        $cover->setName($coverName);
        $cover->setExtension(pathinfo($coverName, PATHINFO_EXTENSION));

        return $cover;
    }
}
