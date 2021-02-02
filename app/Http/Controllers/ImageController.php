<?php

namespace App\Http\Controllers;

use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Spatie\Image\Exceptions\InvalidManipulation;

class ImageController extends Controller
{
    /**
     * @param $size
     * @param $path
     *
     * @throws InvalidManipulation
     *
     * @return mixed
     */
    public static function thumbnail($size, $path, $crop = true)
    {
        $dimensions = config("image.thumbnails.$size");

        if (! $dimensions) {
            return abort(404);
        }

        $thumbnail = get_thumbnail($path, $size);

        // dump(pathinfo($thumbnail['filepath']));
        $thumbnail['filepath'] = str_replace('.jpeg', '.jpg', $thumbnail['filepath']);
        // dd($thumbnail['filepath']);
        if (! $thumbnail['resolved']) {
            if ($crop) {
                Image::load("$path")
                    ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                    ->save($thumbnail['filepath']);
            } else {
                Image::load("$path")
                    ->save($thumbnail['filepath']);
            }
            // Image::load("$path")
            //     ->fit(Manipulations::FIT_CROP, 480, 770)
            //     ->save($thumbnail['filepath']);
        }

        return response()->file($thumbnail['filepath']);
    }
}
