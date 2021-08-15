<?php

use InlineSvg\Collection;
use InlineSvg\Transformers\Cleaner;
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
        $filename = md5("$size/$path").'.jpg';
        $thumbnailPath = "storage/cache/$filename";

        return [
            'resolved' => file_exists($thumbnailPath),
            'filename' => $filename,
            'filepath' => $thumbnailPath,
        ];
    }
}

if (! function_exists('svg')) {
    /**
      * Get SVG icon inline with attributes
      *
      * @param string $name name of SVG file
      * @param int $size if SVG is a square, just square length
      * @param string|null $class additionnal class for <svg class="">
      * @param int|null $width width of SVG to overwrite $size if SVG is not square
      * @param int|null $height height of SVG to overwrite $size if SVG is not square
      *
      * @return string $requestedIcon <svg></svg>
      */
    function svg(
        string $name,
        int $size = 20,
        string $class = '',
        int $width = null,
        int $height = null
    ) : string {
        $svgPath = base_path(config('app.svg'));
        $icons = Collection::fromPath($svgPath);
        $icons->addTransformer(new Cleaner());
  
        if ($width === null && $height === null) {
            $width = $size;
            $height = $size;
        }
  
        $requestedIcon = $icons->get($name);
        $requestedIcon = $requestedIcon->withAttributes([
            'width'  => $width,
            'height' => $height,
            'class'  => $class,
        ]);
        return $requestedIcon;
    }
}

if (! function_exists('getUrlStorage')) {
    function getUrlStorage(string $path)
    {
        $path = str_replace('\\', '/', $path);
        $path_array = explode("/", $path);
        $path_array_begin = 0;
        // find key for storage path
        foreach ($path_array as $key => $path_el) {
            if ($path_el === 'storage') {
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
