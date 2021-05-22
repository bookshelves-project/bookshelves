<?php

namespace App\Providers\MetadataExtractor;

use DateTime;
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
     * @param bool   $isDebug
     *
     * @return MetadataExtractor|bool
     */
    public static function run(string $epubFilePath, bool $isDebug = false): MetadataExtractor | bool
    {
        $metadata = [];

        try {
            $metadata = MetadataExtractorTools::parseXMLFile($epubFilePath);
        } catch (\Throwable $th) {
            MetadataExtractorTools::error('XML file', $epubFilePath);
            // dump($th);

            return false;
        }

        $title = (string) $metadata['title'];
        $creators = (array) $metadata['creators'];
        $contributor = (string) $metadata['contributor'];
        $description = (string) $metadata['description'];
        $date = (string) $metadata['date'];
        $identifiers = (array) $metadata['identifiers'];
        $publisher = (string) $metadata['publisher'];
        $subjects = (array) $metadata['subjects'];
        $language = (string) $metadata['language'];
        $rights = (string) $metadata['rights'];
        $serie = (string) $metadata['serie'];
        $volume = (string) $metadata['volume'];
        $cover = $metadata['cover']['file'];
        $coverExtension = $metadata['cover']['extension'];
        $epubFilePath = (string) $epubFilePath;

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
