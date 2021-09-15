<?php

namespace App\Providers\MetadataExtractor;

use DateTime;
use App\Utils\BookshelvesTools;
use App\Providers\MetadataExtractor\Parsers\BookParser;
use App\Providers\MetadataExtractor\Parsers\SerieParser;
use App\Providers\MetadataExtractor\Parsers\CreatorsParser;
use App\Providers\MetadataExtractor\Parsers\SubjectsParser;
use App\Providers\MetadataExtractor\Parsers\IdentifiersParser;

class MetadataExtractor
{
    public function __construct(
        public ?string $title = null,
        public ?string $title_sort = null,
        public ?array $creators = [],
        public ?string $contributor = null,
        public ?string $description = null,
        public ?DateTime $date = null,
        public ?IdentifiersParser $identifiers = null,
        public ?string $publisher = null,
        public ?array $subjects = [],
        public ?string $language = null,
        public ?string $rights = null,
        public ?string $serie = null,
        public ?string $serie_sort = null,
        public ?int $volume = 0,
        public ?string $cover = null,
        public ?string $coverExtension = null,
        public ?string $epubFilePath = null,
    ) {
        if (! $this->identifiers) {
            $this->identifiers = new IdentifiersParser();
        }
    }

    /**
     * Get metadata from EPUB and create Book
     * with relationships.
     *
     * If OPF file into EPUB file have any error,
     * return bool `false`
     *
     * @param string $epubFilePath Absolute path of EPUB file to extract metadata
     *
     * @return MetadataExtractor|bool
     */
    public static function run(string $epubFilePath, bool $debug = false): MetadataExtractor | bool
    {
        $metadata = [];

        try {
            $metadata = MetadataExtractorTools::parseXMLFile($epubFilePath, $debug);
        } catch (\Throwable $th) {
            throw $th;
            MetadataExtractorTools::error('XML file', $epubFilePath);

            return false;
        }

        try {
            $title = (string) $metadata['title'] ?? null;
            $creators = (array) $metadata['creators'] ?? null;
            $contributor = (string) $metadata['contributor'] ?? null;
            $description = (string) $metadata['description'] ?? null;
            $date = (string) $metadata['date'] ?? null;
            $identifiers = (array) $metadata['identifiers'] ?? null;
            $publisher = (string) $metadata['publisher'] ?? null;
            $subjects = (array) $metadata['subjects'] ?? null;
            $language = (string) $metadata['language'] ?? null;
            $rights = (string) $metadata['rights'] ?? null;
            $serie = (string) $metadata['serie'] ?? null;
            $volume = (string) $metadata['volume'] ?? null;
            $cover = $metadata['cover_file'] ?? null;
            $coverExtension = $metadata['cover_extension'] ?? null;
            $epubFilePath = (string) $epubFilePath ?? null;
        } catch (\Throwable $th) {
            BookshelvesTools::console(__METHOD__, $th);
            return false;
        }

        $identifiersParsed = IdentifiersParser::run(identifiers: $identifiers);
        $serieParsed = SerieParser::run(serie: $serie, volume: $volume);
        $subjectsParsed = SubjectsParser::run(subjects: $subjects);
        $creatorsParsed = CreatorsParser::run(creators: $creators);
        $publisherParsed = (string) $publisher;
        $languageParsed = (string) strtolower($language);
        $bookParsed = BookParser::run(
            title: $title,
            contributor: $contributor,
            description: $description,
            date: $date,
            rights: $rights
        );

        if (! $bookParsed->title) {
            echo "No title, eBook not created";
            return false;
        }

        $epubParser = new MetadataExtractor(
            title: $bookParsed->title,
            title_sort: $bookParsed->title_sort,
            creators: $creatorsParsed->creators,
            contributor: $bookParsed->contributor,
            description: $bookParsed->description,
            date: $bookParsed->date,
            identifiers: $identifiersParsed,
            publisher: $publisherParsed,
            subjects: $subjectsParsed->subjects,
            language: $languageParsed,
            rights: $bookParsed->rights ? $bookParsed->rights : null,
            serie: $serieParsed->title,
            serie_sort: $serieParsed->title_sort,
            volume: $serieParsed->number,
            cover: $cover,
            coverExtension: $coverExtension,
            epubFilePath: $epubFilePath,
        );

        return $epubParser;
    }
}
