<?php

namespace App\Providers\Bookshelves;

use File;
use Storage;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class CoverGenerator
{
    public static function run(array $metadata, bool $isDebug = false)
    {
        $book = $metadata['book'];
        $cover_extension = $metadata['cover_extension'];
        $cover = $metadata['cover'];

        if (! $book->image) {
            // Cover extract raw file
            // $cover_filename_without_extension = md5("$book->slug-$book->author");
            $cover_filename_without_extension = strtolower($book->slug.'-'.$book->authors[0]->slug);
            $cover_file = $cover_filename_without_extension.'.'.$cover_extension;
            if ($cover_extension) {
                Storage::disk('public')->put("covers-raw/$cover_file", $cover);
            }

            if ($cover_extension) {
                $size = 'book_cover';
                $dimensions = config('image.thumbnails.book_cover');
                $dimensions_thumbnail = config('image.thumbnails.book_thumbnail');
                $path = public_path("storage/covers-raw/$cover_file");
                $optimizerChain = OptimizerChainFactory::create();

                $disk = 'books';
                try {
                    $file_path = File::get($path);
                    $book->addMediaFromString($file_path)
                    ->setName($book->slug)
                    ->setFileName($book->slug.'.jpg')
                    ->toMediaCollection($disk, $disk);

                    $image_path = $book->getMedia($disk)->first()->getPath();
                    Image::load($image_path)
                    ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                    ->save($image_path);
                    $optimizerChain->optimize($image_path);
                    // copy of original cover in WEBP
                // $new_extension = '.jpg';
                // $path_original = public_path('storage/covers/original/'.$cover_filename_without_extension.$new_extension);
                // Image::load($path)
                //     ->save($path_original);
                // $cover_file = $cover_filename_without_extension.$new_extension;

                // if (! $isDebug) {
                //     $optimizerChain->optimize($path_original);

                //     $path_thumbnail = public_path('storage/covers/thumbnail/'.$cover_filename_without_extension.$new_extension);

                //     $optimizerChain->optimize($path_original);

                //     $path_basic = public_path('storage/covers/basic/'.$cover_filename_without_extension.$new_extension);
                //     Image::load($path_original)
                //         ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                //         ->save($path_basic);
                //     $optimizerChain->optimize($path_basic);
                // }

                // $cover_model = Cover::firstOrCreate([
                //     'name'      => $cover_filename_without_extension,
                //     'extension' => $new_extension,
                // ]);

                // $book->cover()->associate($cover_model);
                // $book->save();
                } catch (\Throwable $th) {
                    // self::generateError('covers');
                }
            }
        }
    }
}
