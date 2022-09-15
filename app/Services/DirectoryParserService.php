<?php

namespace App\Services;

/**
 * Directory parser.
 *
 * Example
 *
 * ```php
 * $files = DirectoryParserService::parseDirectoryFiles($path);
 * ```
 */
class DirectoryParserService
{
    /**
     * Parse directory (recursive).
     *
     * @param mixed $dir
     *
     * @return \Generator<mixed, mixed, mixed, void>
     */
    public static function parseDirectoryFiles($dir)
    {
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if (! is_dir($path)) {
                yield $path;
            } elseif ('.' != $value && '..' != $value) {
                yield from self::parseDirectoryFiles($path);
                yield $path;
            }
        }
    }
}
