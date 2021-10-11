<?php

namespace App\Services\ParserEngine;

use App\Services\ParserEngine\Models\OpfCreator;
use App\Services\ParserEngine\Models\OpfIdentifier;
use DateTime;
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
        public ?array $creators = [],
        public ?array $contributor = [],
        public ?string $description = null,
        public ?DateTime $date = null,
        public ?array $identifiers = null,
        public ?string $publisher = null,
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
        $metadata = self::OpfToArray($epubPath, $debug);

        $opf->title = $metadata['title'];
        $opf->title_sort = ParserTools::getSortString($metadata['title']);
        $opf->slug = Str::slug($metadata['title']);
        $opf->slug_lang = Str::slug($metadata['title'].' '.$metadata['language']);
        $opf->creators = $metadata['creators'];
        $opf->contributor = $metadata['contributors'];
        $opf->description = ParserTools::cleanText($metadata['description'], 'html', 5000);
        $opf->date = $metadata['date'];
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
     * - `title`: `string`
     * - `creators`: `OpfCreator[]`
     * - `contributors`: `string[]`
     * - `description`: `string`
     * - `date`: `DateTime`
     * - `identifiers`: `OpfIdentifier[]`
     * - `publisher`: `string`
     * - `subjects`: `string[]`
     * - `language`: `string`
     * - `rights`: `string`
     * - `serie`: `string`
     * - `volume`: `int`
     * - `cover_file`: `string`
     * - `cover_extension`: `string`.
     */
    public static function OpfToArray(string $epubPath, bool $debug = false): array
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
            $epub_filename = pathinfo($epubPath)['basename'];
            Storage::disk('public')->put("/debug/{$epub_filename}.opf", $opf);
        }

        // Transform OPF to Array
        try {
            $opf_as_array = ParserTools::XMLtoArray($opf);
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

        // create unique name for cover
        // $token = bin2hex(openssl_random_pseudo_bytes(5));
        // $name = $metadata['title'];
        // $extension = '.' . $metadata['cover_extension'];
        // $cover_name = Str::slug("$token $name");
        // $cover_name .= $extension;

        // store to `storage/temp`
        // Storage::disk('public')->put("temp/$cover_name", $cover);
        // $metadata['cover_file'] = public_path("/temp/$cover_name");

        $metadata['cover_file'] = $cover;

        $zip->close();

        return $metadata;
    }

    /**
     * Transform OPF/XML file as array.
     */
    public static function parseOpf(array $opf, string $epubPath, bool $debug = false): array
    {
        // set $opf to PACKAGE key, first key of OPF
        $opf = $opf['PACKAGE'];
        $cover = null;

        // MANIFEST contain an array of all files into EPUB
        $manifest = $opf['MANIFEST']['ITEM'];
        $i = 0;
        foreach ($manifest as $key => $value) {
            // search if images exist
            if ('image/jpeg' === $value['MEDIA-TYPE'] || 'image/png' === $value['MEDIA-TYPE']) {
                ++$i;
                // Check if cover exist in images
                if ('cover' === $value['ID']) {
                    $cover = $value;
                // If not, get first existing image
                // If EPUB is dirty, it's possible for cover to have another name
                // If you want to have right cover file, use a tool like Calibre to create new clean EPUB file
                } elseif (1 === $i) {
                    $cover = $value;
                }
            }
        }
        // add cover path to OPF
        $opf['COVER'] = $cover;

        // If debug, create JSON file with OPF data
        if ($debug) {
            $title = pathinfo($epubPath)['basename'];

            try {
                $opfToJson = json_encode($opf, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                Storage::disk('public')->put("/debug/{$title}.json", $opfToJson);
            } catch (\Throwable $th) {
                ParserTools::console(__METHOD__, $th);
            }
        }

        // remove MANIFEST and SPINE, useless data now
        unset($opf['MANIFEST'], $opf['SPINE']);

        $metadata = [];

        try {
            // set to METADATA key
            $meta = $opf['METADATA'];

            // get *creators* which will be authors
            // use OpfCreatorParser to get name and role
            // role can be 'aut' for author but it can be 'translator' for example
            $creators_raw = $meta['DC:CREATOR'] ?? [];
            $creators_data = [];
            // check if array contain *content* key or is multi
            if (array_key_exists('content', $creators_raw) || is_array(current($creators_raw))) {
                // check if multi array aka multi authors
                if (is_array(current($creators_raw))) {
                    foreach ($creators_raw as $key => $creator) {
                        $creator = new OpfCreator(
                            name: $creator['content'],
                            role: $creator['OPF:ROLE']
                        );
                        array_push($creators_data, $creator);
                    }
                } else {
                    $creator = new OpfCreator(
                        name: $creators_raw['content'],
                        role: $creators_raw['OPF:ROLE']
                    );
                    array_push($creators_data, $creator);
                }
            }
            // clean creators
            // TODO remove duplicates inside same ebook (with reverse)
            $creators_data = array_map('unserialize', array_unique(array_map('serialize', $creators_data)));
            // foreach ($creators_data as $key => $creator) {
            //     $creator = implode(' ', array_reverse(explode(' ', $creator->name)));
            // }

            // get contributor
            $contributors_raw = $meta['DC:CONTRIBUTOR'] ?? [];
            $contributors_data = [];
            foreach ($contributors_raw as $key => $value) {
                // only one contributor
                if ('content' === $key) {
                    array_push($contributors_data, $value);
                // More than one contributor
                } elseif (is_numeric($key)) {
                    array_push($contributors_data, $value['content']);
                }
            }
            $contributors_raw = implode(',', $contributors_data);

            // get identifiers like ISBN
            $identifiers_raw = $meta['DC:IDENTIFIER'] ?? [];
            $identifiers_data = [];
            foreach ($identifiers_raw as $key => $value) {
                // More than one identifier
                if (is_numeric($key)) {
                    try {
                        array_push($identifiers_data, [
                            'id' => $value['OPF:SCHEME'],
                            'value' => $value['content'],
                        ]);
                    } catch (\Throwable $th) {
                        // if identifier is too dirty, skip it
                    }
                } else {
                    $identifiers_data = [];
                }
            }
            // only one identifier
            if (! sizeof($identifiers_data) && array_key_exists('content', $identifiers_raw)) {
                $identifiers_data[0]['id'] = $identifiers_raw['OPF:SCHEME'];
                $identifiers_data[0]['value'] = $identifiers_raw['content'];
            }
            // update identifiers with OpfIdentifier to get an identifier object
            $identifiers = [];
            foreach ($identifiers_data as $key => $identifier) {
                $identifier = OpfIdentifier::create($identifier);
                array_push($identifiers, $identifier);
            }
            $identifiers_data = $identifiers;

            // get subjects aka tags
            $subjects_data = [];

            try {
                $subjects_raw = (array) $meta['DC:SUBJECT'] ?? null;
                foreach ($subjects_raw as $key => $value) {
                    array_push($subjects_data, $value);
                }
            } catch (\Throwable $th) {
                // if subject if too dirty, skip it
            }

            // get series data
            // EPUB 2 not support series, we use Calibre series data
            $serie_data = null;
            $volume_data = null;
            // set sub key META
            // search if series and volume exist
            $meta_serie = $meta['META'] ?? [];
            foreach ($meta_serie as $key => $value) {
                if ('calibre:series' === $value['NAME']) {
                    $serie_data = $value['CONTENT'];
                }
                if ('calibre:series_index' === $value['NAME']) {
                    $volume_data = intval($value['CONTENT']);
                }
            }

            // if cover is available from MANIFEST
            // - define cover path into EPUB/ZIP file
            // - define extension of cover
            if ($cover) {
                $cover_file = $cover['HREF'] ?? null;
                $cover_extension = pathinfo($cover['HREF'], PATHINFO_EXTENSION) ?? null;
            } else {
                echo 'NO COVER';
            }

            $date = null;
            if (array_key_exists('DC:DATE', $meta)) {
                $date = is_string($meta['DC:DATE']) ? $meta['DC:DATE'] : null;
            }

            $metadata = [
                'title' => $meta['DC:TITLE'], // title is too important, crash if not
                'creators' => $creators_data,
                'contributors' => $contributors_data,
                'description' => $meta['DC:DESCRIPTION'] ?? null,
                'date' => new DateTime($date),
                'identifiers' => $identifiers_data,
                'publisher' => $meta['DC:PUBLISHER'] ?? null,
                'subjects' => $subjects_data,
                'language' => $meta['DC:LANGUAGE'] ?? 'unknown', // language is important, if not defined use *unknown*
                'rights' => $meta['DC:RIGHTS'] ?? null,
                'serie' => $serie_data,
                'volume' => $volume_data,
                'cover_file' => $cover_file ?? null,
                'cover_extension' => $cover_extension ?? null,
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
        } catch (\Throwable $th) {
            ParserTools::console(__METHOD__, $th);
        }

        return $metadata;
    }
}
