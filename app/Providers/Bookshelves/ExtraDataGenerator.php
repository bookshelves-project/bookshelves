<?php

namespace App\Providers\Bookshelves;

use File;
use Storage;
use App\Models\Book;
use App\Models\Cover;
use App\Models\Serie;
use App\Models\Author;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\Http;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ExtraDataGenerator
{
    public static function generateAuthorPicture(Author $author, bool $is_debug): Author
    {
        $name = $author->name;
        $author_slug = $author->slug;
        $name = str_replace(' ', '%20', $name);
        $url = "https://en.wikipedia.org/w/api.php?action=query&origin=*&titles=$name&prop=pageimages&format=json&pithumbsize=512";
        $pictureAuthorDefault = database_path('seeders/media/authors/no-picture.jpg');
        if (! $is_debug) {
            try {
                $response = Http::get($url);
                $response = $response->json();
                $pictureAuthor = $response['query']['pages'];
                $pictureAuthor = reset($pictureAuthor);
                $pictureAuthor = $pictureAuthor['thumbnail']['source'];
            } catch (\Throwable $th) {
            }
            if (! is_string($pictureAuthor)) {
                $pictureAuthor = $pictureAuthorDefault;
                $defaultPictureFile = File::get($pictureAuthorDefault);
                $author->addMediaFromString($defaultPictureFile)
                    ->setName($author->slug)
                    ->setFileName($author->slug.'.jpg')
                    ->toMediaCollection('authors', 'authors');
            } else {
                $contents = file_get_contents($pictureAuthor);
                // $size = 'book_cover';
                // $dimensions = config("image.thumbnails.$size");
                $author->addMediaFromUrl($pictureAuthor)
                    ->setName($author->slug)
                    ->setFileName($author->slug.'.jpg')
                    ->toMediaCollection('authors', 'authors');
                // Storage::disk('public')->put("authors/$author_slug.jpg", $contents);

                // Image::load($image_path)
                //     ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                //     ->save();

                // $pictureAuthor = "storage/authors/$author_slug.jpg";
            }
            $optimizerChain = OptimizerChainFactory::create();
            $dimensions = config('image.thumbnails.book_cover');
            $image_path = $author->getMedia('authors')->first()->getPath();
            Image::load($image_path)
                ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                ->save($image_path);
            $optimizerChain->optimize($image_path);
        } else {
            $pictureAuthor = $pictureAuthorDefault;
        }

        // $author->picture = $pictureAuthor;
        $author->save();

        return $author;
    }

    public static function generateSerieCover(Serie $serie): Serie
    {
        // Add special cover if exist from `database/seeders/medias/series/`
        // Check if JPG file with series' slug name exist
        // To know slug name, check into database when serie was created
        $disk = 'series';
        $dimensions = config('image.thumbnails.book_cover');
        $custom_series_path = database_path("seeders/media/$disk/$serie->slug.jpg");
        $optimizerChain = OptimizerChainFactory::create();
        if (File::exists($custom_series_path)) {
            $file_path = File::get($custom_series_path);
            $serie->addMediaFromString($file_path)
                    ->setName($serie->slug)
                    ->setFileName($serie->slug.'.jpg')
                    ->toMediaCollection($disk, $disk);

            $image_path = $serie->getMedia($disk)->first()->getPath();
            Image::load($image_path)
                ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                ->save($image_path);
            $optimizerChain->optimize($image_path);
        } else {
            $bookIfExist = Book::whereSerieNumber(1)->whereSerieId($serie->id)->first();
            if ($bookIfExist) {
                $book = $bookIfExist;
                $file_path = File::get($book->getMedia('books')->first()->getPath());
                $serie->addMediaFromString($file_path)
                    ->setName($serie->slug)
                    ->setFileName($serie->slug.'.jpg')
                    ->toMediaCollection($disk, $disk);

                $image_path = $serie->getMedia($disk)->first()->getPath();
                Image::load($image_path)
                    ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                    ->save($image_path);
                $optimizerChain->optimize($image_path);
            }
        }

        return $serie;
    }

    public static function generateSerieLanguage(Serie $serie)
    {
        $bookSelected = $serie->books[0];
        foreach ($serie->books as $key => $book) {
            if (1 === $book->serie_number) {
                $bookSelected = $book;
            }
        }
        if ($bookSelected->language) {
            $serie->language()->associate($bookSelected->language);
            $serie->save();
        }
    }
}
