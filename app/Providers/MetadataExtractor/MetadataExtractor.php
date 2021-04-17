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
        public ?string $cover_extension = null,
        public ?string $file_path = null,
    ) {
        if (! $this->identifiers) {
            $this->identifiers = new IdentifiersParser();
        }
    }

    /**
     * Get metadata from EPUB and create Book
     * with relationships.
     *
     * @param string $file_path
     * @param bool   $is_debug
     *
     * @return MetadataExtractor
     */
    public static function run(string $file_path, bool $is_debug = false): MetadataExtractor | bool
    {
        try {
            $xml_parsed = MetadataExtractorTools::parseXmlFile($file_path);
            $metadata = $xml_parsed['metadata'];
            $coverFile = $xml_parsed['coverFile'];
        } catch (\Throwable $th) {
            MetadataExtractorTools::error('XML file', $file_path);

            return false;
        }

        $title = (string) $metadata['title'];
        $creators = $metadata['creator'];
        $contributor = (string) json_encode($metadata['contributor']);
        $description = (string) $metadata['description'];
        $date = is_array($metadata['date']) ? $metadata['date'][0] : $metadata['date'];
        $identifiers = (array) $metadata['identifier'];
        $publisher = (string) $metadata['publisher'];
        $subjects = (array) $metadata['subject'];
        $language = (string) $metadata['language'];
        $rights = (string) $metadata['rights'];
        $serie = (string) $metadata['serie'];
        $volume = (string) $metadata['volume'];
        $cover_extension = (string) $metadata['cover_extension'];
        $file_path = (string) $file_path;

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
            cover: $coverFile,
            cover_extension: $cover_extension,
            file_path: $file_path,
        );

        return $epubParser;
    }
}
