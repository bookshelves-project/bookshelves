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
            return asset("cache/resolve/{$size}/{$path}");
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
        $filename = md5("{$size}/{$path}").'.jpg';
        $thumbnailPath = "storage/cache/{$filename}";

        return [
            'resolved' => file_exists($thumbnailPath),
            'filename' => $filename,
            'filepath' => $thumbnailPath,
        ];
    }
}

if (! function_exists('getUrlStorage')) {
    function getUrlStorage(string $path)
    {
        $path = str_replace('\\', '/', $path);
        $path_array = explode('/', $path);
        $path_array_begin = 0;
        // find key for storage path
        foreach ($path_array as $key => $path_el) {
            if ('storage' === $path_el) {
                $path_array_begin = $key;
            }
        }
        // remove begin of path
        $path_array = array_splice($path_array, $path_array_begin);
        // recreate path
        $path = implode('/', $path_array);
        // remove for storage link
        $path = str_replace('app/public/', '', $path);

        return config('app.url').'/'.$path;
    }
}
