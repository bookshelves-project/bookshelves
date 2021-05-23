<?php

namespace App\Providers\MetadataExtractor\Parsers;

use DateTime;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class BookParser
{
    public function __construct(
        public ?string $title = null,
        public ?string $title_sort = null,
        public ?string $contributor = null,
        public ?string $description = null,
        public ?DateTime $date = null,
        public ?string $rights = null,
    ) {
    }

    /**
     * Generate Book from parameters.
     */
    public static function run(string $title, ?string $contributor, ?string $description, ?string $date, ?string $rights): BookParser
    {
        $book_title = $title;
        $title_sort = MetadataExtractorTools::getSortString($book_title);

        $description = MetadataExtractorTools::cleanText($description, 'html', 5000);

        if (strlen($rights) > 255) {
            $rights = substr($rights, 0, 255);
        }

        return new BookParser(
            title: $book_title,
            title_sort: $title_sort,
            contributor: $contributor,
            description: $description,
            date: new DateTime($date),
            rights: $rights,
        );
    }
}
