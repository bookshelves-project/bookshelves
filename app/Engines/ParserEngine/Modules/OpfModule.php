<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\BookCreator;
use App\Engines\ParserEngine\BookIdentifier;
use App\Engines\ParserEngine\XmlParser;
use App\Services\ConsoleService;
use ZipArchive;

class OpfModule
{
    public function __construct(
        public ?object $opf = null,
        public ?float $version = null,
        public ?ParserEngine $engine = null,
    ) {
    }

    /**
     * Parse OPF file as PHP XML file.
     */
    public static function create(ParserEngine $parser): ParserEngine|false
    {
        // Find and open EPUB as ZIP file
        $zip = new ZipArchive();
        $zip->open($parser->file_path);

        // Parse EPUB/ZIP file
        for ($i = 0; $i < $zip->numFiles; ++$i) {
            $file = $zip->statIndex($i);
            // Extract .opf file by it extension as string
            if (strpos($file['name'], '.opf')) {
                $opf = $zip->getFromName($file['name']);
            }
        }
        if (! isset($opf)) {
            ConsoleService::print("OpfModule: can't get OPF");

            return false;
        }

        // If debug mode, create OPF file into `debug`
        if ($parser->debug) {
            ParserEngine::printFile($opf, "{$parser->file_name}.opf", true);
        }

        // Transform OPF to Array
        try {
            $parser = OpfModule::parse($opf, $parser);
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

    public static function parse(string $opf_file, ParserEngine $parser): ParserEngine
    {
        $xml = new XmlParser($opf_file);
        $module = new OpfModule();

        $opf = $xml->xml_to_array();
        $module->opf = json_decode(json_encode($opf, JSON_FORCE_OBJECT));

        $module->version = 2.0;
        if ($module->opf?->{'@attributes'}?->version) {
            $module->version = floatval($module->opf->{'@attributes'}->version);
        }
        $module->engine = $parser;

        $is_supported = match ($module->version) {
            2.0 => $module->version2($module),
            default => false,
        };

        // If debug, create JSON file with OPF data
        if ($parser->debug) {
            ParserEngine::printFile($opf, "{$parser->file_name}-metadata.json");
        }
        if (! $is_supported) {
            ConsoleService::print("OpfModule {$module->version} not supported");
        }

        return $parser;
    }

    private function version2(OpfModule $module): static
    {
        $this->extractCover($module->engine);

        foreach ($this->opf->metadata as $node_key => $node) {
            $this->extractRaw($node_key, $node, 'dc:title', 'title');
            $this->extractRaw($node_key, $node, 'dc:description', 'description');
            $this->extractRaw($node_key, $node, 'dc:date', 'date');
            $this->extractRaw($node_key, $node, 'dc:publisher', 'publisher');
            $this->extractRaw($node_key, $node, 'dc:language', 'language');
            $this->extractRaw($node_key, $node, 'dc:rights', 'rights');
            $this->extractSubjects($node_key, $node, 'dc:subject');
            $this->extractCreators($node_key, $node, 'dc:creator');
            $this->extractContributor($node_key, $node, 'dc:contributor');
            $this->extractIdentifiers($node_key, $node, 'dc:identifier');
            $this->extractCalibreMeta($node_key, $node, 'meta');
        }

        return $this;
    }

    private function extractRaw(string $node_key, string|object $node, string $extract_key, string $attribute): static
    {
        if ($node_key === $extract_key) {
            $this->engine->{$attribute} = $node;
        }

        return $this;
    }

    /**
     * Get serie and volume.
     */
    private function extractCalibreMeta(string $node_key, string|object $node, string $extract_key): ParserEngine
    {
        if ($node_key === $extract_key) {
            $array = json_decode(json_encode($node), true);
            foreach ($array as $value) {
                $value = json_decode(json_encode($value, JSON_FORCE_OBJECT));
                if ('calibre:series' === $value->{'@attributes'}?->name) {
                    $this->engine->serie = $value->{'@attributes'}->content;
                }
                if ('calibre:series_index' === $value->{'@attributes'}->name) {
                    $this->engine->volume = $value->{'@attributes'}->content;
                }
            }
        }

        return $this->engine;
    }

    /**
     * Get identifiers like ISBN.
     */
    private function extractIdentifiers(string $node_key, string|object $node, string $extract_key): static
    {
        if ($node_key === $extract_key) {
            $array = json_decode(json_encode($node), true);
            $identifiers = [];
            foreach ($array as $identifier_value) {
                $identifier_value = json_decode(json_encode($identifier_value, JSON_FORCE_OBJECT));
                $identifier = BookIdentifier::create([
                    'id' => $identifier_value->{'@attributes'}?->scheme,
                    'value' => $identifier_value->{'@content'},
                ]);
                array_push($identifiers, $identifier);
            }
            $this->engine->identifiers = $identifiers;
        }

        return $this;
    }

    /**
     * Get contributor.
     */
    private function extractContributor(string $node_key, string|object $node, string $extract_key): static
    {
        if ($node_key === $extract_key && is_object($node)) {
            $contributors = [];
            array_push($contributors, $node->{'@content'});
            $this->engine->contributor = $contributors;
        }

        return $this;
    }

    /**
     * Get *creators* which will be authors
     * - use BookCreator to get name and role
     * - role can be 'aut' for author but it can be 'translator' for example.
     */
    private function extractCreators(string $node_key, string|object $node, string $extract_key): static
    {
        if ($node_key === $extract_key) {
            $creators = [];
            $array = json_decode(json_encode($node), true);
            if (array_key_exists(0, $array)) {
                foreach ($array as $creator_value) {
                    $new_creator = $this->extractCreator($creator_value);
                    array_push($creators, $new_creator);
                }
            } else {
                $new_creator = $this->extractCreator($node);
                array_push($creators, $new_creator);
            }
            $creators = array_map('unserialize', array_unique(array_map('serialize', $creators)));
            $this->engine->creators = $creators;
        }

        return $this;
    }

    private function extractSubjects(string $node_key, string|object $node, string $extract_key): static
    {
        if ($node_key === $extract_key) {
            $subjects = [];
            if (is_string($node)) {
                array_push($subjects, $node);
            } else {
                $subjects = json_decode(json_encode($node), true);
                foreach ($subjects as $subject) {
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
    private function extractCover(ParserEngine $parser): static
    {
        $cover = null;

        foreach ($this->opf?->manifest?->item as $node) {
            $id = $node->{'@attributes'}->id;
            $type = $node->{'@attributes'}->{'media-type'};
            $href = $node->{'@attributes'}->href;

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

        if (! empty($cover)) {
            $this->engine->cover_name = $cover;
            $this->engine->cover_extension = pathinfo($cover, PATHINFO_EXTENSION);
        } else {
            ConsoleService::print('No cover from OpfModule');
        }

        return $this;
    }

    private function extractCreator(array|object $creator): BookCreator
    {
        $creator = json_decode(json_encode($creator, JSON_FORCE_OBJECT));

        return new BookCreator(
            name: $creator->{'@content'},
            role: $creator->{'@attributes'}?->{'role'}
        );
    }
}
