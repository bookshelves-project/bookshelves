<?php

namespace App\Engines\ParserEngine\Parsers;

use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use Kiwilan\Steward\Services\DirectoryParserService;

/**
 * @property ?BookTypeEnum $type
 * @property ?string       $path
 */
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
    public static function make(int $limit = null)
    {
        $types_enum = BookTypeEnum::toArray();
        $formats_enum = BookFormatEnum::toArray();

        $list = [];
        $i = 0;

        foreach ($types_enum as $type => $type_value) {
            $books_path = storage_path("app/public/data/books/{$type}");

            $service = DirectoryParserService::make($books_path);
            $files = $service->files;

            foreach ($files as $key => $path) {
                if (array_key_exists('extension', pathinfo($path))) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);

                    if (array_key_exists($ext, $formats_enum)) {
                        $i++;
                        $list["{$i}"] = new FilesTypeParser(BookTypeEnum::from($type), $path);
                    }
                }
            }
        }

        if ($limit) {
            return array_slice($list, 0, $limit);
        }

        return $list;
    }
}
