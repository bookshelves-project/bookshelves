<?php

namespace App\Providers\Bookshelves;

use File;
use App\Models\Book;
use App\Models\Cover;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Support\Facades\Http;

class ExtraDataGenerator
{
    public static function generateAuthorPicture(Author $author, bool $is_debug): Author
    {
        if (! $author->image) {
            $name = $author->name;
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
                    $author->addMediaFromUrl($pictureAuthor)
                        ->setName($author->slug)
                        ->setFileName($author->slug.'.jpg')
                        ->toMediaCollection('authors', 'authors');
                }
            } else {
                $pictureAuthor = $pictureAuthorDefault;
            }

            $author = $author->refresh();

            return $author;
        }

        return $author;
    }

    public static function generateSerieCover(Serie $serie): Serie
    {
        if (! $serie->image) {
            // Add special cover if exist from `database/seeders/medias/series/`
            // Check if JPG file with series' slug name exist
            // To know slug name, check into database when serie was created
            $disk = 'series';
            $custom_series_path = database_path("seeders/media/$disk/$serie->slug.jpg");

            if (File::exists($custom_series_path)) {
                $file_path = File::get($custom_series_path);
                $serie->addMediaFromString($file_path)
                    ->setName($serie->slug)
                    ->setFileName($serie->slug.'.jpg')
                    ->toMediaCollection($disk, $disk);
            } else {
                $bookIfExist = Book::whereSerieNumber(1)->whereSerieId($serie->id)->first();
                if ($bookIfExist) {
                    $book = $bookIfExist;
                    $file_path_exist = File::exists($book->getMedia('books')->first()?->getPath());
                    if ($file_path_exist) {
                        $file_path = File::get($book->getMedia('books')->first()->getPath());
                        $serie->addMediaFromString($file_path)
                            ->setName($serie->slug)
                            ->setFileName($serie->slug.'.jpg')
                            ->toMediaCollection($disk, $disk);
                    }
                } else {
                    dump("$serie->title book not found");
                }
            }

            $serie = $serie->refresh();

            return $serie;
        }

        return $serie;
    }

    public static function generateSerieLanguage(Serie $serie): Serie
    {
        if (! $serie->language) {
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

            return $serie;
        }

        return $serie;
    }
}
