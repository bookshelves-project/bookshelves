<?php

namespace App\Services;

class DirectoryParserService
{
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
