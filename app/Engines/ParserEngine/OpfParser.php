<?php

namespace App\Engines\ParserEngine;

use App\Services\ConsoleService;
use DateTime;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class OpfParser
{
    public function __construct(
        public ?string $title = null,
        /** @var BookCreator[] $creators */
        public ?array $creators = [],
        public ?array $contributor = [],
        public ?string $description = null,
        public ?DateTime $released_on = null,
        /** @var BookIdentifier[] $identifiers */
        public ?array $identifiers = null,
        public ?string $publisher = null,
        public ?array $subjects = [],
        public ?string $language = null,
        public ?string $rights = null,
        public ?string $serie = null,
        public ?int $volume = 0,
        public ?string $cover_name = null,
        public ?string $cover_file = null,
        public ?string $cover_extension = null,
    ) {
    }

    /**
     * Parse OPF file as PHP XML file.
     */
    public static function create(string $epub_path, bool $debug = false): OpfParser|false
    {
        $parser = new OpfParser();

        // Find and open EPUB as ZIP file
        $zip = new ZipArchive();
        $zip->open($epub_path);

        // Parse EPUB/ZIP file
        for ($i = 0; $i < $zip->numFiles; ++$i) {
            $file = $zip->statIndex($i);
            // Extract .opf file by it extension as string
            if (strpos($file['name'], '.opf')) {
                $opf = $zip->getFromName($file['name']);
            }
        }
        if (! isset($opf)) {
            ConsoleService::print("OpfParser: can't get OPF");

            return false;
        }

        // If debug mode, create OPF file into `debug`
        if ($debug) {
            $epub_filename = pathinfo($epub_path)['basename'];
            self::printFile($opf, $epub_filename);
        }

        // Transform OPF to Array
        try {
            $xml = new XmlParser($opf);
            $opf_array = $xml->xml_to_array();

            $parser = self::parseOpf($opf_array, $epub_path, $parser, $debug);
        } catch (\Throwable $th) {
            ConsoleService::print(__METHOD__, $th);
        }

        // Parse EPUB/ZIP file
        for ($i = 0; $i < $zip->numFiles; ++$i) {
            $file = $zip->statIndex($i);
            // If cover exist, extract it as string
            if ($parser->cover_name) {
                $cover = $zip->getFromName($parser->cover_name);
                $parser->cover_file = base64_encode($cover);
            }
        }

        $zip->close();

        return $parser;
    }

    /**
     * Transform OPF/XML file as array.
     *
     * Parse `metadata` node.
     * - title
     * - creators (authors)
     * - contributor
     * - description
     * - publisher
     * - released_on
     * - identifiers
     * - subjects (tags)
     * - language
     * - series title
     * - series_index (volume).
     */
    public static function parseOpf(array $opf, string $epub_path, OpfParser $parser, bool $debug = false): OpfParser
    {
        $metadata_node = $opf['metadata'];
        $manifest_node = $opf['manifest']['item'];

        $title = null;
        $creators = [];
        $contributor = [];
        $description = null;
        $released_on = '';
        $identifiers = [];
        $publisher = null;
        $subjects = [];
        $language = 'unknown';
        $rights = null;
        $serie = null;
        $volume = 0;
        $cover = null;
        $cover_name = null;
        $cover_extension = null;

        $cover = self::extractCover($manifest_node);
        if (! empty($cover)) {
            $cover_name = $cover;
            $cover_extension = pathinfo($cover, PATHINFO_EXTENSION);
        } else {
            echo 'NO COVER';
        }

        foreach ($metadata_node as $key => $value) {
            if ('dc:title' === $key) {
                $title = $value;
            }

            /*
            * Get *creators* which will be authors
            * - use BookCreator to get name and role
            * - role can be 'aut' for author but it can be 'translator' for example.
            */
            if ('dc:creator' === $key) {
                if (array_key_exists(0, $value)) {
                    foreach ($value as $creator_key => $creator_value) {
                        $new_creator = self::extractAuthor($creator_value);
                        if ($new_creator) {
                            array_push($creators, $new_creator);
                        }
                    }
                } else {
                    $new_creator = self::extractAuthor($value);
                    if ($new_creator) {
                        array_push($creators, $new_creator);
                    }
                }
            }
            $creators = array_map('unserialize', array_unique(array_map('serialize', $creators)));

            /*
            * Get contributor.
            */
            if ('dc:contributor' === $key) {
                foreach ($value as $contributor_key => $contributor_value) {
                    if ('@content' === $contributor_key) {
                        array_push($contributor, $contributor_value);
                    }
                }
            }

            /*
             * Get identifiers like ISBN.
             */
            if ('dc:identifier' === $key) {
                foreach ($value as $identifier_key => $identifier_value) {
                    $identifier_id = null;
                    if (
                        array_key_exists('@attributes', $identifier_value)
                        && array_key_exists('scheme', $identifier_value['@attributes'])
                    ) {
                        $identifier_id = $identifier_value['@attributes']['scheme'];
                    }

                    $identifier_raw = [
                        'id' => $identifier_id,
                        'value' => array_key_exists('@content', $identifier_value) ? $identifier_value['@content'] : null,
                    ];

                    $identifier = BookIdentifier::create($identifier_raw);
                    array_push($identifiers, $identifier);
                }
            }

            /*
             * Get description.
             */
            if ('dc:description' === $key) {
                $description = $value;
            }

            /*
             * Get publisher.
             */
            if ('dc:publisher' === $key) {
                $publisher = $value;
            }

            /*
             * Get date.
             */
            if ('dc:date' === $key) {
                $released_on = $value && ! str_contains($value, '0101') ? $value : null;
            }

            /*
             * Get subject.
             */
            if ('dc:subject' === $key) {
                if (is_array($value)) {
                    array_push($subjects, ...$value);
                }
            }

            /*
             * Get language.
             */
            if ('dc:language' === $key) {
                $language = $value;
            }

            /*
             * Get rights.
             */
            if ('dc:rights' === $key) {
                $rights = $value;
            }

            /*
             * Get serie and volume.
             */
            if ('meta' === $key) {
                foreach ($value as $meta_value) {
                    if (
                        array_key_exists('@attributes', $meta_value)
                        && array_key_exists('name', $meta_value['@attributes'])
                        && array_key_exists('content', $meta_value['@attributes'])
                    ) {
                        if ('calibre:series' === $meta_value['@attributes']['name']) {
                            $serie = $meta_value['@attributes']['content'];
                        }
                        if ('calibre:series_index' === $meta_value['@attributes']['name']) {
                            $volume = $meta_value['@attributes']['content'];
                        }
                    }
                }
            }
        }

        $parser->title = $title;
        $parser->creators = $creators;
        $parser->contributor = $contributor;
        $parser->description = $description;
        $parser->released_on = $released_on ? new DateTime($released_on) : null;
        $parser->identifiers = $identifiers;
        $parser->publisher = $publisher;
        $parser->subjects = $subjects;
        $parser->language = $language;
        $parser->rights = $rights;
        $parser->serie = $serie;
        $parser->volume = $volume;
        $parser->cover_name = $cover_name;
        $parser->cover_extension = $cover_extension;

        // If debug, create JSON file with OPF data
        if ($debug) {
            $title = pathinfo($epub_path)['basename'];

            self::printFile($opf, "{$title}-metadata.json");
            self::printFile($parser, "{$title}-parser.json");
        }

        return $parser;
    }

    /**
     * Search if images exist.
     * - if cover is available from manifest
     * - define cover path into EPUB/ZIP file
     * - define extension of cover.
     */
    private static function extractCover(array $manifest_node): string
    {
        $cover = null;

        foreach ($manifest_node as $node) {
            $id = $node['@attributes']['id'];
            $type = $node['@attributes']['media-type'];
            $href = $node['@attributes']['href'];

            if ('image/jpeg' === $type || 'image/png' === $type) {
                /*
                 * Check if cover exist in images.
                 */
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

        return $cover;
    }

    private static function extractAuthor(array $value): BookCreator|false
    {
        if (array_key_exists('@content', $value)) {
            $creator_name = $value['@content'];
        }
        if (
            array_key_exists('@attributes', $value)
            && array_key_exists('role', $value['@attributes'])
        ) {
            $creator_role = $value['@attributes']['role'];
        }

        if (isset($creator_name)) {
            return new BookCreator(
                name: $creator_name,
                role: $creator_role ?? null
            );
        }

        return false;
    }

    private static function printFile(mixed $file, string $name): bool
    {
        try {
            $file = json_encode($file, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            return Storage::disk('public')->put("/debug/{$name}", $file);
        } catch (\Throwable $th) {
            ConsoleService::print(__METHOD__, $th);
        }

        return false;
    }
}
