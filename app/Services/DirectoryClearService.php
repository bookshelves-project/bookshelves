<?php

namespace App\Services;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * Clear directories.
 *
 * Example
 *
 * ```php
 * DirectoryClearService::create($paths, $ignore);
 * ```
 */
class DirectoryClearService
{
    public function __construct(
        public array $paths,
        public ?array $ignore = [],
    ) {
    }

    public static function create(array $paths, array $ignore = ['.gitignore']): DirectoryClearService
    {
        $service = new DirectoryClearService($paths, $ignore);
        foreach ($paths as $path) {
            $service->clear($path);
        }

        return $service;
    }

    /**
     * Remove all files into selected directory from but keep files into $ignore.
     */
    public function clear(string $path)
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $outputStyle = new OutputFormatterStyle('red', '', ['bold', 'blink']);
        $output->getFormatter()->setStyle('fire', $outputStyle);

        foreach (glob("{$path}/*") as $file) {
            if (! in_array(basename($file), $this->ignore)) {
                if (is_dir($file)) {
                    $this->rmdir_recursive($file);
                } else {
                    unlink($file);
                }
            }
        }

        $output->writeln('Clear storage/'.basename($path));
    }

    public function rmdir_recursive($dir)
    {
        $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($it as $file) {
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
        rmdir($dir);
    }
}
