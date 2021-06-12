<?php

namespace App\Http\Controllers;

use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Spatie\Image\Exceptions\InvalidManipulation;
use Intervention\Image\Exception\NotReadableException;

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
    public static function thumbnail($method, $size, $path)
    {
        switch ($method) {
            case 'crop':
                $method = Manipulations::FIT_CROP;
                break;
            case 'fill':
                $method = Manipulations::FIT_FILL;
                break;

            default:
                $method = Manipulations::FIT_CROP;
                break;
        }

        $dimensions = config("image.thumbnails.$size");

        if (! $dimensions) {
            return abort(404);
        }

        $filename = md5("$size/$path").'.'.pathinfo($path, PATHINFO_EXTENSION);
        $thumbnail = "storage/cache/$filename";

        if (! file_exists($thumbnail)) {
            try {
                Image::load("storage/$path")
                    ->useImageDriver(config('image.driver'))
                    ->fit(
                        $method,
                        $dimensions['width'],
                        $dimensions['height']
                    )
                    ->optimize()
                    ->save($thumbnail);
            } catch (NotReadableException $e) {
                return abort(404);
            }
        }

        return response()
            ->file($thumbnail)
            ->setMaxAge(31536000)
            ->setExpires(date_create()->modify('+1 years'));
    }
}
