<?php

use Illuminate\Contracts\Container\BindingResolutionException;

if (! function_exists('image_cache')) {
    /**
     * Resolve image url.
     *
     * @throws BindingResolutionException
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
     */
    function get_thumbnail(string $path, string $size, bool $crop = true): array
    {
        $filename = md5("$size/$path") . '.jpg';
        $thumbnailPath = "storage/cache/$filename";

        return [
            'resolved' => file_exists($thumbnailPath),
            'filename' => $filename,
            'filepath' => $thumbnailPath,
        ];
    }
}
