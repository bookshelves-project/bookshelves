<?php

namespace App\Engines\ParserEngine\Parsers;

use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use Kiwilan\Steward\Services\DirectoryParserService;

class FilesTypeParser
{
    public function __construct(
        public ?BookTypeEnum $type,
        public ?string $path,
    ) {
    }

    /**
     * Get all files from `storage/data/books`.
     *
     * @return false|FilesTypeParser[]
     */
    public static function parseDataFiles(int $limit = null)
    {
        $book_types = BookTypeEnum::toArray();
        // $book_types = [
        //     'audio' => 'audio',
        //     // "comic" => "comic",
        //     'essay' => 'essay',
        //     'handbook' => 'handbook',
        //     'novel' => 'novel',
        // ];
        $formats = BookFormatEnum::toArray();

        $files = [];
        foreach ($book_types as $type => $path) {
            $path = storage_path("app/public/data/books/{$type}");

            foreach (DirectoryParserService::parse($path) as $file_path) {
                if (array_key_exists('extension', pathinfo($file_path))) {
                    $ext = pathinfo($file_path, PATHINFO_EXTENSION);
                    if (array_key_exists($ext, $formats)) {
                        array_push($files, new FilesTypeParser(BookTypeEnum::from($type), $file_path));
                    }
                }
            }
        }

        if ($limit) {
            return array_slice($files, 0, $limit);
        }

        return $files;
    }
}
