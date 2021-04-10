<?php

namespace App\Providers\Bookshelves;

use File;
use DateTime;
use App\Models\Tag;
use App\Models\Book;
use App\Utils\Tools;
use App\Models\Cover;
use App\Models\Serie;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\GoogleBook;
use App\Models\Identifier;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ExtraDataGenerator
{
    /**
     * Generate Author image from Wikipedia if found
     * If not use default image 'database/seeders/media/authors/no-picture.jpg'
     * Manage by spatie/laravel-medialibrary.
     *
     * @param Author $author
     * @param bool   $is_debug
     *
     * @return Author
     */
    public static function generateAuthorPicture(Author $author): Author
    {
        if ($author->getMedia('authors')->isEmpty()) {
            $name = $author->name;
            $name = Str::slug($name, '%20');
            $url = "https://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=$name&format=json";
            $pictureAuthorDefault = database_path('seeders/media/authors/no-picture.jpg');
            $pageId = null;
            try {
                $response = Http::get($url);
                $response = $response->json();
                $pageId = $response['query']['search'];
                if (array_key_exists(0, $pageId)) {
                    $pageId = $pageId[0]['pageid'];
                }
            } catch (\Throwable $th) {
            }
            if ($pageId) {
                $url = "http://en.wikipedia.org/w/api.php?action=query&prop=info&pageids=$pageId&inprop=url&format=json&prop=info|extracts&inprop=url&prop=pageimages&pithumbsize=512";
                $pictureAuthor = null;
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

    /**
     * Generate Author description from Wikipedia if found.
     *
     * @param Author $author
     * @param bool   $is_debug
     *
     * @return Author
     */
    public static function generateAuthorDescription(Author $author): Author
    {
        if (! $author->description) {
            $name = $author->name;
            $name = Str::slug($name, '%20');
            $url = "https://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=$name&format=json";
            $pageId = null;
            try {
                $response = Http::get($url);
                $response = $response->json();
                $pageId = $response['query']['search'];
                if (array_key_exists(0, $pageId)) {
                    $pageId = $pageId[0]['pageid'];
                }
            } catch (\Throwable $th) {
            }
            if ($pageId) {
                $url = "http://en.wikipedia.org/w/api.php?action=query&prop=info&pageids=$pageId&inprop=url&format=json&prop=info|extracts&inprop=url";
                $desc = null;
                try {
                    $response = Http::get($url);
                    $response = $response->json();
                    $desc = $response['query']['pages'];
                    $desc = reset($desc);
                    $url = $desc['fullurl'];
                    $desc = $desc['extract'];
                    $desc = Tools::stringLimit($desc, 500);
                } catch (\Throwable $th) {
                }
                if (is_string($desc)) {
                    $author->description = $desc;
                    $author->wikipedia_link = $url;
                    $author->save();
                }
            }

            return $author;
        }

        return $author;
    }

    /**
     * Generate Serie description from Wikipedia if found.
     *
     * @param Serie $serie
     * @param bool  $is_debug
     *
     * @return Serie
     */
    public static function generateSerieDescription(Serie $serie): Serie
    {
        if (! $serie->description) {
            $name = $serie->title;
            $lang = $serie->language->slug;
            $name = str_replace(' ', '%20', $name);
            $name = strtolower($name);
            $url = "https://$lang.wikipedia.org/w/api.php?action=query&list=search&srsearch=$name&format=json";
            $pageId = null;
            try {
                $response = Http::get($url);
                $response = $response->json();
                $pageId = $response['query']['search'];
                if (array_key_exists(0, $pageId)) {
                    $pageId = $pageId[0]['pageid'];
                }
            } catch (\Throwable $th) {
            }
            if ($pageId) {
                $url = "http://$lang.wikipedia.org/w/api.php?action=query&prop=info&pageids=$pageId&inprop=url&format=json&prop=info|extracts&inprop=url";
                $desc = null;
                try {
                    $response = Http::get($url);
                    $response = $response->json();
                    $desc = $response['query']['pages'];
                    $desc = reset($desc);
                    $url = $desc['fullurl'];
                    $desc = $desc['extract'];
                    $desc = Tools::stringLimit($desc, 500);
                } catch (\Throwable $th) {
                }
                if (is_string($desc)) {
                    $serie->description = $desc;
                    $serie->wikipedia_link = $url;
                    $serie->save();
                }
            }

            return $serie;
        }

        return $serie;
    }

    /**
     * Generate Serie image from 'database/seeders/media/series' if JPG file with Serie slug exist
     * if not get image from Book with 'book_number' like '1'.
     *
     * Manage by spatie/laravel-medialibrary.
     *
     * @param Serie $serie
     *
     * @return Serie
     */
    public static function generateSerieCover(Serie $serie): Serie
    {
        if ($serie->getMedia('series')->isEmpty()) {
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
                }
                // TODO
                // Setup Logs
                // "$serie->title book not found"
            }

            $serie = $serie->refresh();

            return $serie;
        }

        return $serie;
    }

    /**
     * Generate Language relationship for Serie from first Book of Serie.
     *
     * @param Serie $serie
     *
     * @return Serie
     */
    public static function generateSerieLanguage(Serie $serie): Serie
    {
        if (! $serie->language) {
            $bookSelected = $serie->books[0];
            foreach ($serie->books as $key => $book) {
                if (1 === $book->serie_number) {
                    $bookSelected = $book;
                } else {
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

    /**
     * Get data from Google Books API with ISBN from meta
     * Example: https://www.googleapis.com/books/v1/volumes?q=isbn:9782700239904.
     *
     * Get all useful data to improve Book, Identifier, Publisher and Tag
     * If data exist, create GoogleBook associate with Book with useful data to purchase eBook
     *
     * @param Identifier $identifier
     * @param Book       $book
     *
     * @return Book
     */
    public static function getDataFromGoogleBooks(Identifier $identifier, Book $book): Book
    {
        if ($identifier->isbn13) {
            $isbn = $identifier->isbn13;
        } elseif ($identifier->isbn) {
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
            $publisher = null;

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
                $publisher = (string) $volumeInfo['publisher'];
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
                    if ('ISBN_13' === $new_identifier['type']) {
                        $new_isbn13 = $new_identifier['identifier'];
                    }
                    if ('ISBN_10' === $new_identifier['type']) {
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

                    $book_tags = $book->tags;
                    $book_tags_list = [];
                    foreach ($book_tags as $key => $tagIn) {
                        array_push($book_tags_list, $tagIn->slug);
                    }
                    if (! in_array($tag->slug, $book_tags_list)) {
                        $book->tags()->save($tag);
                        $book->save();
                    }
                }
            } catch (\Throwable $th) {
            }

            ! $book->date && $date ? $book->date = $date : null;
            ! $book->description && $description ? $book->description = $description : null;
            ! $book->pageCount && $pageCount ? $book->page_count = $pageCount : null;
            ! $book->maturityRating && $maturityRating ? $book->maturity_rating = $maturityRating : null;
            ! $book->language && $language ? $book->language = $language : null;
            if (! $book->publisher && $publisher) {
                $publisher = Publisher::create([
                    'name' => $publisher,
                    'slug' => Str::slug($publisher, '-'),
                ]);
                $book->publisher()->associate($publisher);
            }
            $book->save();

            $identifier = Identifier::find($book->identifier->id);
            ! $identifier->isbn ? $book->identifier->isbn = $new_isbn : null;
            ! $identifier->isbn13 ? $book->identifier->isbn13 = $new_isbn13 : null;
            $identifier->save();

            if ($previewLink || $retailPriceAmount || $retailPriceCurrencyCode || $buyLink) {
                $googleBook = GoogleBook::create([
                    'preview_link'          => $previewLink,
                    'retail_price'          => $retailPriceAmount,
                    'retail_price_currency' => $retailPriceCurrencyCode,
                    'buy_link'              => $buyLink,
                    'created_at'            => new DateTime(),
                ]);
                $googleBook->book()->save($book);
            }
        }

        return $book;
    }
}
