<?php

namespace App\Providers\Bookshelves;

use App\Http\Resources\IdentifierResource;
use File;
use App\Models\Book;
use App\Models\Cover;
use App\Models\Serie;
use App\Models\Author;
use App\Models\GoogleBook;
use App\Models\Identifier;
use App\Models\Tag;
use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ExtraDataGenerator
{
    public static function generateAuthorPicture(Author $author, bool $is_debug): Author
    {
        if (! $author->image) {
            $name = $author->name;
            $name = str_replace(' ', '%20', $name);
            $url = "https://en.wikipedia.org/w/api.php?action=query&origin=*&titles=$name&prop=pageimages&format=json&pithumbsize=512";
            $pictureAuthorDefault = database_path('seeders/media/authors/no-picture.jpg');
            $pictureAuthor = null;
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
                        ->setFileName($author->slug.'.'.config('bookshelves.cover_extension'))
                        ->toMediaCollection('authors', 'authors');
                } else {
                    $author->addMediaFromUrl($pictureAuthor)
                        ->setName($author->slug)
                        ->setFileName($author->slug.'.'.config('bookshelves.cover_extension'))
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
                    ->setFileName($serie->slug.'.'.config('bookshelves.cover_extension'))
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
                            ->setFileName($serie->slug.'.'.config('bookshelves.cover_extension'))
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

    public static function getDataFromGoogleBooks(Identifier $identifier, Book $book): Book
    {
        if ($identifier->isbn13) {
            $isbn = $identifier->isbn13;
        } else if($identifier->isbn) {
            $isbn = $identifier->isbn;
        } else {
            $isbn = null;
        }

        if ($isbn) {
            $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn";

            $date = null;
            $description = null;
            $industryIdentifiers = null;
            $pageCount = null;
            $categories = null;
            $maturityRating = null;
            $language = null;
            $previewLink = null;

            $retailPriceAmount = null;
            $retailPriceCurrencyCode = null;
            $buyLink = null;

            $new_isbn13 = null;
            $new_isbn = null;

            try {
                $response = Http::get($url);
                $response = $response->json();
                $response = $response['items'][0];
                $volumeInfo = $response['volumeInfo'];
                $date = (string) $volumeInfo['publishedDate'];
                $description = (string) $volumeInfo['description'];
                $industryIdentifiers = (array) $volumeInfo['industryIdentifiers'];
                $pageCount = (int) $volumeInfo['pageCount'];
                $categories = (array) $volumeInfo['categories'];
                $maturityRating = (string) $volumeInfo['maturityRating'];
                $language = (string) $volumeInfo['language'];
                $previewLink = (string) $volumeInfo['previewLink'];

                $saleInfo = $response['saleInfo'];
                $isEbook = (bool) $saleInfo['isEbook'];
                $retailPriceAmount = (int) $saleInfo['retailPrice']['amount'];
                $retailPriceCurrencyCode = (string) $saleInfo['retailPrice']['currencyCode'];
                $buyLink = (string) $saleInfo['buyLink'];
                
                foreach ($industryIdentifiers as $key => $new_identifier) {
                    if ($new_identifier['type'] === 'ISBN_13') {
                        $new_isbn13 = $new_identifier['identifier'];
                    }
                    if ($new_identifier['type'] === 'ISBN_10') {
                        $new_isbn = $new_identifier['identifier'];
                    }
                }
                foreach ($categories as $key => $category) {
                    $tagIfExist = Tag::whereSlug(Str::slug($category))->first();
                    $tag = null;
                    if (! $tagIfExist) {
                        $tag = Tag::firstOrCreate([
                            'name' => $category,
                            'slug' => Str::slug($category),
                        ]);
                    }
                    if (! $tag) {
                        $tag = $tagIfExist;
                    }

                    $book->tags()->save($tag);
                }
            } catch (\Throwable $th) {
            }

            !$book->date && $date ? $book->date = $date : null;
            !$book->description && $description ? $book->description = $description : null;
            !$book->pageCount && $pageCount ? $book->page_count = $pageCount : null;
            !$book->maturityRating && $maturityRating ? $book->maturity_rating = $maturityRating : null;
            !$book->language && $language ? $book->language = $language : null;
            $book->save();

            $identifier = Identifier::find($book->identifier->id);
            !$identifier->isbn ? $book->identifier->isbn = $new_isbn : null;
            !$identifier->isbn13 ? $book->identifier->isbn13 = $new_isbn13 : null;
            $identifier->save();

            $googleBook = GoogleBook::create([
                'preview_link' => $previewLink,
                'retail_price' => $retailPriceAmount,
                'retail_price_currency' => $retailPriceCurrencyCode,
                'buy_link' => $buyLink,
                'created_at' => new DateTime(),
            ]);
            $googleBook->book()->save($book);
        }

        return $book;
        
    }
}
