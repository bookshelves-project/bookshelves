<?php

namespace App\Engines\Book;

class IndexationEngine
{
    public const CACHE_PATH = 'storage/data/cache';

    public const INDEX_PATH = '00-index-bookshelves.json';

    public static function save(string $bookTitle, array $bookData): void
    {
        $cachePath = self::getCachePath();
        $indexPath = self::getIndexPath();
        $bookPath = "{$cachePath}/{$bookTitle}.json";

        if (! file_exists($indexPath)) {
            file_put_contents($indexPath, json_encode([]));
        }
        $indexData = json_decode(file_get_contents($indexPath));
        $indexData[] = $bookPath;

        file_put_contents($indexPath, json_encode($indexData));
        file_put_contents($bookPath, json_encode($bookData));
    }

    public static function getCachePath(): string
    {
        return public_path(self::CACHE_PATH);
    }

    public static function getIndexPath(): string
    {
        return self::getCachePath().'/'.self::INDEX_PATH;
    }

    public static function getIndex(): array
    {
        return json_decode(file_get_contents(self::getIndexPath()), true);
    }
}
