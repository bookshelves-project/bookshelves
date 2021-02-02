<?php

if (! function_exists('image_cache')) {
    /**
     * Resolve image url.
     *
     * @param $path
     * @param $size
     *
     * @return string
     */
    function image_cache($path, $size, $crop = true)
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
     * @param $path
     * @param $size
     *
     * @return array
     */
    function get_thumbnail($path, $size, $crop = true)
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
