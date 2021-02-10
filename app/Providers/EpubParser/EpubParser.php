<?php

namespace App\Providers\EpubParser;

use App\Providers\EpubParser\Entities\BookParser;
use App\Providers\EpubParser\Entities\CreatorsParser;
use App\Providers\EpubParser\Entities\IdentifiersParser;
use App\Providers\EpubParser\Entities\SerieParser;
use App\Providers\EpubParser\Entities\SubjectsParser;
use DateTime;

class EpubParser
{
    public function __construct(
        public IdentifiersParser $identifiers,
        public ?string $title = null,
        public ?string $title_sort = null,
        public ?array $creators = [],
        public ?string $contributor = null,
        public ?string $description = null,
        public ?DateTime $date = null,
        public ?string $publisher = null,
        public ?array $subjects = [],
        public ?string $language = null,
        public ?string $rights = null,
        public ?string $serie = null,
        public ?string $serie_sort = null,
        public ?int $serie_number = 0,
        public ?string $cover = null,
        public ?string $cover_extension = null,
        public ?string $file_path = null,
    ) {}
    
    /**
     * Get metadata from EPUB and create Book
     * with relationships.
     *
     * @param string $file_path
     * @param bool $is_debug
     *
     * @return EpubParser
     */
    public static function run(string $file_path, bool $is_debug = false): EpubParser|bool
    {
        
        // static::$original_filename = pathinfo($file_path)['filename'];
        try {
            $xml_parsed = EpubParserTools::parseXmlFile($file_path);
            $metadata = $xml_parsed['metadata'];
            $coverFile = $xml_parsed['coverFile'];
        } catch (\Throwable $th) {
            EpubParserTools::error('XML file', $file_path);
            return false;
        }

        $title = $metadata['title'];
        $creators = $metadata['creator'];
        $contributor = $metadata['contributor'];
        $description = $metadata['description'];
        $date = $metadata['date'];
        $identifiers = $metadata['identifier'];
        $publisher = $metadata['publisher'];
        $subjects = $metadata['subject'];
        $language = $metadata['language'];
        $rights = $metadata['rights'];
        $serie = $metadata['serie'];
        $serie_number = $metadata['serie_number'];
        $cover_extension = $metadata['cover_extension'];
        $file_path = $file_path;
        
        $identifiersParsed = IdentifiersParser::run(identifiers: $identifiers);
        $serieParsed = SerieParser::run(serie: $serie, serie_number: $serie_number);
        $subjectsParsed = SubjectsParser::run(subjects: $subjects);
        $creatorsParsed = CreatorsParser::run(creators: $creators, is_debug: $is_debug);
        $publisherParsed = (string) $publisher;
        $languageParsed = (string) strtolower($language);
        $bookParsed = BookParser::run(
            title: $title,
            contributor: $contributor,
            description: $description,
            date: $date,
            rights: $rights,
            file_path: $file_path
        );

        $epubParser = new EpubParser(
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
            serie_number: $serieParsed?->number ? $serieParsed?->number : 0,
            cover: $coverFile,
            cover_extension: $cover_extension,
            file_path: $file_path,
        );

        return $epubParser;
    }
}
