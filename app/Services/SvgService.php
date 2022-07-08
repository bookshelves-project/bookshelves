<?php

namespace App\Services;

use File;
use Illuminate\Http\Request;
use InlineSvg\Collection;
use InlineSvg\Transformers\Cleaner;

class SvgService
{
    /**
     * Convert SVG with attributes.
     */
    public static function icon(Request $request)
    {
        // $color = $request->color ?? $skill->color;
        // if ($request->color) {
        //     $color = '#'.$color;
        // }

        // $hexa = str_replace('#', '', $color);
        // $path = '/storage/cache/'.$skill->slug.'-'.$hexa.'.svg';
        // $path_to_save = public_path($path);
        // $path_url = config('app.url').$path;
        // if (! File::exists($path_to_save)) {
        //     $icons = Collection::fromPath(pathinfo($skill->image_path)['dirname']);
        //     $icons->addTransformer(new Cleaner());

        //     $requestedIcon = $icons->get($skill->slug);
        //     $requestedIcon = $requestedIcon->withAttributes([
        //         'style' => 'fill: '.$color,
        //     ]);

        //     File::put($path_to_save, $requestedIcon);
        // }

        // return $path_url;
    }

    public static function getIcon(Request $request, string $slug, string $originalPath)
    {
        // $color = $request->color ?? '#000000';
        // if ($request->color) {
        //     $color = '#'.$color;
        // }

        // $hexa = str_replace('#', '', $color);
        // $path = '/storage/cache/'.$slug.'-'.$hexa.'.svg';
        // $path_to_save = public_path($path);
        // $path_url = config('app.url').$path;
        // if (! File::exists($path_to_save)) {
        //     $icons = Collection::fromPath(pathinfo($originalPath)['dirname']);
        //     $icons->addTransformer(new Cleaner());

        //     $requestedIcon = $icons->get($slug);
        //     $requestedIcon = $requestedIcon->withAttributes([
        //         'style' => 'fill: '.$color,
        //     ]);

        //     File::put($path_to_save, $requestedIcon);
        // }

        // return $path_url;
    }

    public static function setColor(string $svg_path, string $slug, string $hexa_color): string
    {
        $icons = Collection::fromPath(pathinfo($svg_path)['dirname'])
            ->addTransformer(new Cleaner());
        $svg = $icons->get($slug);

        $type = str_contains($svg->__toString(), 'stroke="currentColor"')
            ? 'stroke'
            : 'fill';

        return $svg->withAttributes([
            'style' => "{$type}:{$hexa_color}",
        ]);
    }
}
