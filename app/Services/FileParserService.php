<?php

namespace App\Services;

class FileParserService
{
    /**
     * Get all $ext files from $path.
     *
     * - return `array` of *absolute paths* of files
     * - return `false` if not exist
     */
    public static function getFilesList(int $limit = null, string $path = 'public/storage/data/books', string $ext = 'epub'): array|false
    {
        try {
            $files = [];
            // TODO custom dir
            foreach (self::getDirectoryFiles($path) as $file) {
                if (array_key_exists('extension', pathinfo($file)) && $ext === pathinfo($file)['extension']) {
                    $file = str_replace('public/storage/', '', $file);
                    array_push($files, $file);
                }
            }
        } catch (\Throwable $th) {
            echo "storage/data/books not found\n";
            echo $th;

            return false;
        }

        if ($limit) {
            return array_slice($files, 0, $limit);
        }

        return $files;
    }

    /**
     * Parse directory (recursive).
     *
     * @param mixed $dir
     *
     * @return \Generator<mixed, mixed, mixed, void>
     */
    public static function getDirectoryFiles($dir)
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
