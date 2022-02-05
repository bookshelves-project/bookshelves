<?php

namespace App\Services\ParserEngine;

use App\Services\ParserEngine\Models\OpfCreator;
use App\Services\ParserEngine\Models\OpfIdentifier;
use DateTime;
use Exception;
use FluentDOM;
use FluentDOM\DOM\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

/**
 * Parser engine for eBook.
 */
class ParserEngine
{
    public function __construct(
        public ?string $title = null,
        public ?string $title_sort = null,
        public ?string $title_serie_sort = null,
        public ?string $slug = null,
        public ?string $slug_lang = null,
        /** @var OpfCreator[] $creators */
        public ?array $creators = [],
        public ?array $contributor = [],
        public ?string $description = null,
        public ?DateTime $released_on = null,
        public ?array $identifiers = null,
        public ?string $publisher = null,
        /** @var OpfIdentifier[] $subjects */
        public ?array $subjects = [],
        public ?string $language = null,
        public ?string $rights = null,
        public ?string $serie = null,
        public ?string $serie_slug = null,
        public ?string $serie_slug_lang = null,
        public ?string $serie_sort = null,
        public ?int $volume = 0,
        public ?string $cover = null,
        public ?string $coverExtension = null,
        public ?string $epubPath = null,
    ) {
    }

    /**
     * Transform OPF file to ParserEngine.
     */
    public static function create(string $epubPath, bool $debug = false, bool $print = false): ParserEngine
    {
        $opf = new ParserEngine();
        $metadata = self::opfToArray($epubPath, $debug);

        $opf->title = $metadata['title'];
        $opf->title_sort = ParserTools::getSortString($metadata['title']);
        $opf->slug = Str::slug($metadata['title']);
        $opf->slug_lang = Str::slug($metadata['title'].' '.$metadata['language']);
        $opf->creators = $metadata['creators'];
        $opf->contributor = $metadata['contributors'];
        $opf->description = ParserTools::htmlToText($metadata['description']);
        $opf->released_on = $metadata['released_on'] ?? null;
        $opf->identifiers = $metadata['identifiers'];
        $opf->publisher = $metadata['publisher'];
        $opf->subjects = $metadata['subjects'];
        $opf->language = $metadata['language'];
        $opf->rights = substr($metadata['rights'], 0, 255);
        $opf->serie = $metadata['serie'];
        $opf->serie_slug = Str::slug($metadata['serie']);
        $opf->serie_slug_lang = Str::slug($metadata['serie'].' '.$metadata['language']);
        $opf->serie_sort = ParserTools::getSortString($metadata['serie']);
        $opf->volume = $metadata['volume'];
        $opf->epubPath = $epubPath;

        $opf->title_serie_sort = ParserTools::sortTitleWithSerie(
            $opf->title,
            $opf->volume,
            $opf->serie,
        );

        if (! $print) {
            $opf->cover = $metadata['cover_file'];
            $opf->coverExtension = $metadata['cover_extension'];
        }

        return $opf;
    }

    /**
     * Parse OPF file as PHP XML file.
     *
     * - `title`: `string`
     * - `creators`: `OpfCreator[]`
     * - `contributors`: `string[]`
     * - `description`: `string`
     * - `released_on`: `DateTime`
     * - `identifiers`: `OpfIdentifier[]`
     * - `publisher`: `string`
     * - `subjects`: `string[]`
     * - `language`: `string`
     * - `rights`: `string`
     * - `serie`: `string`
     * - `volume`: `int`
     * - `cover_file`: `base64`
     * - `cover_extension`: `string`.
     */
    public static function opfToArray(string $epubPath, bool $debug = false): array
    {
        $metadata = [];
        $opf = '';

        // Find and open EPUB as ZIP file
        $zip = new ZipArchive();
        $zip->open($epubPath);

        // Parse EPUB/ZIP file
        for ($i = 0; $i < $zip->numFiles; ++$i) {
            $file = $zip->statIndex($i);
            // Extract .opf file by it extension as string
            if (strpos($file['name'], '.opf')) {
                $opf = $zip->getFromName($file['name']);
            }
        }

        // If debug mode, create OPF file into `debug`
        if ($debug) {
            try {
                $epub_filename = pathinfo($epubPath)['basename'];
                Storage::disk('public')->put("/debug/{$epub_filename}.opf", $opf);
            } catch (\Throwable $th) {
                ParserTools::console(__METHOD__, $th);
            }
        }

        // Transform OPF to Array
        try {
            $opf_as_array = FluentDOM::load(
                $opf,
            );
            $opf_as_array->registerNamespace('a', 'http://www.idpf.org/2007/opf');
            $metadata = self::parseOpf($opf_as_array, $epubPath, $debug);
        } catch (\Throwable $th) {
            ParserTools::console(__METHOD__, $th);
        }

        // Now, we can have cover
        $cover = null;
        // Parse EPUB/ZIP file
        for ($i = 0; $i < $zip->numFiles; ++$i) {
            $file = $zip->statIndex($i);
            // If cover exist, extract it as string
            if (array_key_exists('cover_file', $metadata) && $metadata['cover_file']) {
                $cover = $zip->getFromName($metadata['cover_file']);
            }
        }

        $metadata['cover_file'] = base64_encode($cover);

        $zip->close();

        return $metadata;
    }

    /**
     * Transform OPF/XML file as array.
     */
    public static function parseOpf(Document $opf, string $epubPath, bool $debug = false): array
    {
        $metadata = [];

        try {
            $packageNode = $opf('/a:package');
            $metaNode = [];
            $manifestNode = [];

            $title = null;
            $creators = [];
            $contributors = [];
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
            $cover_file = null;
            $cover_extension = null;

            /** @var \FluentDOM\DOM\Element $packageValue */
            foreach ($packageNode as $packageValue) {
                /** @var \FluentDOM\DOM\Element $packageChildValue */
                foreach ($packageValue->childNodes as $packageChildValue) {
                    if ('metadata' === $packageChildValue->nodeName) {
                        $metaNode = $packageChildValue;
                    } elseif ('manifest' === $packageChildValue->nodeName) {
                        $manifestNode = $packageChildValue;
                    }
                }
            }

            /*
             * Search if images exist.
             * - if cover is available from manifest
             * - define cover path into EPUB/ZIP file
             * - define extension of cover.
             */
            foreach ($manifestNode as $value) {
                /** @var \FluentDOM\DOM\Element $value */
                $id = $value->getAttribute('id');
                $type = $value->getAttribute('media-type');

                if ('image/jpeg' === $type || 'image/png' === $type) {
                    $href = $value->getAttribute('href');

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

            if ($cover) {
                $cover_file = $cover ?? null;
                $cover_extension = pathinfo($cover, PATHINFO_EXTENSION) ?? null;
            } else {
                echo 'NO COVER';
            }

            /*
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
            foreach ($metaNode as $value) {
                /** @var \FluentDOM\DOM\Element $value */
                // dump($value->tagName);
                if ('dc:title' === $value->tagName) {
                    $title = $value->textContent;
                }

                /*
                 * Get *creators* which will be authors
                 * - use OpfCreatorParser to get name and role
                 * - role can be 'aut' for author but it can be 'translator' for example.
                 */
                if ('dc:creator' === $value->tagName) {
                    $creators_raw = $value;
                    $creator_name = $creators_raw->textContent;
                    $creator_role = null;

                    /** @var \FluentDOM\DOM\Attribute $attr */
                    foreach ($creators_raw->attributes as $attrKey => $attr) {
                        if ('role' === $attrKey) {
                            $creator_role = $attr->textContent;
                        }
                    }
                    $creator = new OpfCreator(
                        name: $creator_name,
                        role: $creator_role
                    );
                    array_push($creators, $creator);
                }

                /*
                 * Get contributor.
                 */
                if ('dc:contributor' === $value->tagName) {
                    array_push($contributors, $value->textContent);
                }

                /*
                 * Get identifiers like ISBN.
                 */
                if ('dc:identifier' === $value->tagName) {
                    $identifier_id = null;

                    /** @var \FluentDOM\DOM\Attribute $attr */
                    foreach ($value->attributes as $attrKey => $attr) {
                        if ('scheme' === $attrKey) {
                            $identifier_id = $attr->textContent;
                        }
                    }
                    $identifier_raw = [
                        'id' => $identifier_id,
                        'value' => $value->textContent,
                    ];
                    $identifier = OpfIdentifier::create($identifier_raw);
                    array_push($identifiers, $identifier);
                }

                /*
                 * Get description.
                 */
                if ('dc:description' === $value->tagName) {
                    $description = $value->textContent;
                }

                /*
                 * Get publisher.
                 */
                if ('dc:publisher' === $value->tagName) {
                    $publisher = $value->textContent;
                }

                /*
                 * Get date.
                 */
                if ('dc:date' === $value->tagName) {
                    $released_on = $value->textContent ? $value->textContent : '';
                }

                /*
                 * Get subject.
                 */
                if ('dc:subject' === $value->tagName) {
                    array_push($subjects, $value->textContent);
                }

                /*
                 * Get language.
                 */
                if ('dc:language' === $value->tagName) {
                    $language = $value->textContent;
                }

                /*
                 * Get rights.
                 */
                if ('dc:rights' === $value->tagName) {
                    $rights = $value->textContent;
                }

                /*
                 * Get serie and volume.
                 */
                if ('meta' === $value->tagName) {
                    if ('calibre:series' === $value->getAttribute('name')) {
                        $serie = $value->getAttribute('content');
                    }
                    if ('calibre:series_index' === $value->getAttribute('name')) {
                        $volume = intval($value->getAttribute('content'));
                    }
                }
            }
        } catch (\Throwable $th) {
            echo $th;

            throw new Exception('ParserEngine::parseOpf(): parsing failed!');
        }

        if (empty($title)) {
            throw new Exception('ParserEngine::parseOpf(): Title is empty!');
        }

        /**
         * Remove duplicates in $creators.
         */
        $creators = array_map('unserialize', array_unique(array_map('serialize', $creators)));

        $metadata = [
            'title' => $title,
            'creators' => $creators,
            'contributors' => $contributors,
            'description' => $description,
            'released_on' => $released_on ? new DateTime($released_on) : null,
            'identifiers' => $identifiers,
            'publisher' => $publisher,
            'subjects' => $subjects,
            'language' => $language,
            'rights' => $rights,
            'serie' => $serie,
            'volume' => $volume,
            'cover_file' => $cover_file,
            'cover_extension' => $cover_extension,
        ];

        // If debug, create JSON file with OPF data
        if ($debug) {
            $title = pathinfo($epubPath)['basename'];

            try {
                $metadata_to_json = json_encode($metadata, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                Storage::disk('public')->put("/debug/{$title}-metadata.json", $metadata_to_json);
            } catch (\Throwable $th) {
                ParserTools::console(__METHOD__, $th);
            }
        }

        return $metadata;
    }
}
