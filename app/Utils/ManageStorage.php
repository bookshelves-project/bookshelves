<?php

namespace App\Utils;

use File;

/**
 * $clean = ManageStorage::generateStorageFiles();
 * $clean = $clean ? 'OK' : 'Error';
 * dump("generateStorageFiles: $clean");.
 */
class ManageStorage
{
    public const DIRECTORIES = [
        'documents',
        'projects',
        'icons',
        'formations',
        'fonts',
        'skills',
    ];

    public static function generateStorageFiles(): bool
    {
        $dirs = self::DIRECTORIES;
        // clean for each DIRECTORIES storage/app/public/
        foreach ($dirs as $key => $dir) {
            $clean = File::cleanDirectory(storage_path("app/public/$dir"));
        }
        // clean storage/app/public/cache/
        $files = storage_path('app/public/cache/*'); // get all file names
        $files = glob($files);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        // copy all directories in seeders/storage/ into storage/app/public/
        foreach ($dirs as $key => $dir) {
            self::directoryToStorage($dir);
        }

        return $clean;
    }

    public static function directoryToStorage($dir)
    {
        $database_files = database_path('seeders/storage/');
        $src = $database_files . $dir;
        $dst = storage_path('app/public/' . $dir);
        self::recurseCopy($src, $dst);
    }

    public static function recurseCopy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst, 0775, true);
        while (false !== ($file = readdir($dir))) {
            if (('.' != $file) && ('..' != $file)) {
                if (is_dir($src . '/' . $file)) {
                    self::recurseCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public static function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ('.' != $object && '..' != $object) {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && ! is_link($dir . '/' . $object)) {
                        self::rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                    } else {
                        unlink($dir . DIRECTORY_SEPARATOR . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }
}
