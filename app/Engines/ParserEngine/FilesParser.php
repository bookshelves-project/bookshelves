<?php

namespace App\Engines\ParserEngine;

use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use App\Services\DirectoryParserService;

class FilesParser
{
    public function __construct(
        public ?BookTypeEnum $type,
        public ?string $path,
    ) {
    }

    /**
     * Get all files.
     *
     * @return false|FilesParser[]
     */
    public static function getFilesList(int $limit = null)
    {
        $book_types = BookTypeEnum::toArray();
        $ext = 'epub';

        $files = [];
        foreach ($book_types as $type => $path) {
            $path = storage_path("app/public/data/books/{$type}");

            foreach (DirectoryParserService::getDirectoryFiles($path) as $file_path) {
                if (array_key_exists('extension', pathinfo($file_path))) {
                    $ext = pathinfo($file_path)['extension'];
                    if (array_key_exists($ext, BookFormatEnum::toArray())) {
                        array_push($files, new FilesParser(BookTypeEnum::from($type), $file_path));
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
