<?php

use Illuminate\Contracts\Container\BindingResolutionException;

if (! function_exists('image_cache')) {
    /**
     * Resolve image url.
     *
     * @param string $path
     * @param string $size
     * @param bool   $crop
     *
     * @throws BindingResolutionException
     *
     * @return string
     */
    function image_cache(string $path, string $size, bool $crop = true): string
    {
        if (false !== strpos($path, 'http')) {
            return $path;
        }

        $thumbnail = get_thumbnail($path, $size);

        if (! $thumbnail['resolved']) {
            return asset("cache/resolve/$size/$path");
        }

        return asset($thumbnail['filepath']);
    }
}

if (! function_exists('get_thumbnail')) {
    /**
     * Resolve image url.
     *
     * @param string $path
     * @param string $size
     * @param bool   $crop
     *
     * @return array
     */
    function get_thumbnail(string $path, string $size, bool $crop = true): array
    {
        $filename = md5("$size/$path").'.jpg';
        $thumbnailPath = "storage/cache/$filename";

        return [
            'resolved' => file_exists($thumbnailPath),
            'filename' => $filename,
            'filepath' => $thumbnailPath,
        ];
    }
}

if (! function_exists('stripAccents')) {
    function stripAccents($stripAccents)
    {
        return strtr(utf8_decode($stripAccents), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
}

if (! function_exists('human_filesize')) {
    function human_filesize($bytes, $decimals = 2)
    {
        $sz = [
            'B',
            'Ko',
            'Mo',
            'Go',
            'To',
            'Po',
        ];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).' '.@$sz[$factor];
    }
}
