<?php

if (! function_exists('generate_image')) {
    function generate_image($value, $size = 'medium', $method = 'crop')
    {
        return $value ? image_cache($value, $size, $method) : null;
    }
}

if (! function_exists('image_cache')) {
    /**
     * Resolve image url.
     *
     * @param $path
     * @param $size
     *
     * @return string
     */
    function image_cache($path, $size, $method = 'crop')
    {
        if (false !== strpos($path, 'http')) {
            return $path;
        }

        $thumbnail = get_thumbnail($path, $size);

        if (! $thumbnail['resolved']) {
            return asset("cache/resolve/$method/$size/$path");
        }

        return asset($thumbnail['filepath']);
    }
}

if (! function_exists('get_thumbnail')) {
    /**
     * Resolve image url.
     *
     * @param $path
     * @param $size
     *
     * @return array
     */
    function get_thumbnail($path, $size, $crop = true)
    {
        $filename = md5("$size/$path").'.'.pathinfo($path, PATHINFO_EXTENSION);
        $thumbnailPath = "storage/cache/$filename";

        return [
            'resolved' => file_exists($thumbnailPath),
            'filename' => $filename,
            'filepath' => $thumbnailPath,
        ];
    }
}
