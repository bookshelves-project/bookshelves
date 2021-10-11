<?php

namespace App\Services\ParserEngine;

class ParserList
{
    /**
     * Get all EPUB files from `storage/data/books`.
     *
     * - return `array` of *absolute paths* of eBooks
     * - return `false` if `raw/books` not exist
     */
    public static function getEbooks(int $limit = null, string $path = 'public/storage/data/books'): array|false
    {
        try {
            // Get all files in raw/books/
            // $files = Storage::disk('public')->allFiles('raw/books');
            $epubsFiles = [];
            // TODO custom dir
            foreach (self::getDirectoryFiles($path) as $file) {
                if (array_key_exists('extension', pathinfo($file)) && 'epub' === pathinfo($file)['extension']) {
                    $file = str_replace('public/storage/', '', $file);
                    array_push($epubsFiles, $file);
                }
            }
        } catch (\Throwable $th) {
            echo "storage/data/books not found\n";
            echo $th;

            return false;
        }

        if ($limit) {
            return array_slice($epubsFiles, 0, $limit);
        }

        return $epubsFiles;
    }

    /**
     * Parse directory (recursive).
     *
     * @param mixed $dir
     *
     * @return Generator<mixed, mixed, mixed, void>
     */
    private static function getDirectoryFiles($dir)
    {
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if (! is_dir($path)) {
                yield $path;
            } elseif ('.' != $value && '..' != $value) {
                yield from self::getDirectoryFiles($path);
                yield $path;
            }
        }
    }
}
