<?php

namespace App\Providers\EpubParser\Entities;

use Illuminate\Support\Str;
use App\Providers\EpubParser\EpubParserTools;
use DateTime;
use League\HTMLToMarkdown\HtmlConverter;
use Stevebauman\Purify\Facades\Purify;

class BookParser
{
    public function __construct(
        public ?string $title = null,
        public ?string $title_sort = null,
        public ?string $contributor = null,
        public ?string $description = null,
        public ?DateTime $date = null,
        public ?string $rights = null,
    ) {}
    
    /**
     * Generate Book from parameters.
     *
     * @param string      $title
     * @param string|null $description
     * @param string|null $date
     *
     * @return BookParser
     */
    public static function run(string $title, ?string $contributor, ?string $description, ?string $date, ?string $rights, ?string $file_path): BookParser
    {
        $book_title = $title;
        $title_sort = EpubParserTools::getSortString($book_title);

        $isUTF8 = mb_check_encoding($description, 'UTF-8');
        if ($isUTF8) {
            $description = Purify::clean($description);
            $description = iconv('UTF-8', 'UTF-8//IGNORE', $description);
            $description = preg_replace('#<a.*?>.*?</a>#i', '', $description);
            $converter = new HtmlConverter();
            try {
                $description = $converter->convert($description);
                $description = strip_tags($description, '<br>');
                $description = Str::markdown($description);
            } catch (\Throwable $th) {
                EpubParserTools::error('book description', $file_path);
            }
        }

        
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
