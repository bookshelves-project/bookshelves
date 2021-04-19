<?php

namespace App\Providers\Bookshelves;

use File;
use Http;
use Storage;
use DateTime;
use App\Models\Tag;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\GoogleBook;
use App\Models\Identifier;
use Illuminate\Support\Str;
use App\Providers\MetadataExtractor\MetadataExtractor;
use InvalidArgumentException;

class BookProvider
{
    /**
     * Generate Book image from original cover string file.
     * Manage by spatie/laravel-medialibrary.
     *
     * @param MetadataExtractor $metadataExtractor
     *
     * @return Book
     */
    public static function cover(Book $book): Book
    {
        $cover = Storage::disk('public')->get("/covers-raw/$book->id.jpg");

        if (! $book->image) {
            $disk = 'books';
            $book->addMediaFromString($cover)
                ->setName($book->slug)
                ->setFileName($book->slug.'.'.config('bookshelves.cover_extension'))
                ->toMediaCollection($disk, $disk);

            $book = $book->refresh();
        }

        return $book;
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
    public static function googleBook(Identifier $identifier, Book $book): Book
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
            ! $book->page_count && $pageCount ? $book->page_count = $pageCount : null;
            ! $book->maturity_rating && $maturityRating ? $book->maturity_rating = $maturityRating : null;
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

    /**
     * Generate new EPUB file with standard name.
     * Managed by spatie/laravel-medialibrary.
     *
     * @param Book   $book
     * @param string $epubFilePath
     *
     * @return bool
     */
    public static function epub(Book $book, string $epubFilePath): bool
    {
        $ebook_extension = pathinfo($epubFilePath)['extension'];

        $serieName = '';
        if ($book->serie) {
            $serieName = $book->serie->slug;
        }
        $authorName = '';
        if ($book->authors) {
            if (array_key_exists(0, $book->authors->toArray())) {
                $authorName = $book->authors[0]->slug.'_';
            }
        }
        $serieNumber = '';
        if ($book->volume) {
            $serieNumber = $book->volume;
            if (1 === strlen((string) $book->volume)) {
                $serieNumber = '0'.$book->volume;
            }
            $serieName = $serieName.'-'.$serieNumber.'_';
        } else {
            $serieName = $serieName.'_';
        }
        $bookName = $book->slug;

        $new_file_name = "$authorName$serieName$bookName";

        $result = false;
        if (pathinfo($epubFilePath)['basename'] !== $new_file_name) {
            try {
                $epub_file = File::get(storage_path("app/public/$epubFilePath"));
                $book->addMediaFromString($epub_file)
                    ->setName($new_file_name)
                    ->setFileName($new_file_name.".$ebook_extension")
                    ->toMediaCollection('epubs', 'epubs');
                $result = true;
            } catch (\Throwable $th) {
            }
        }

        return $result;
    }

    /**
     * Generate new Book with all relations.
     *
     * @param MetadataExtractor $metadataExtractor
     *
     * @return Book
     */
    public static function convertMetadata(MetadataExtractor $metadataExtractor): Book
    {
        $bookIfExist = Book::whereSlug(Str::slug($metadataExtractor->title, '-'))->first();
        $book = null;
        if (! $bookIfExist) {
            $book = self::book($metadataExtractor);
            $book = self::authors($metadataExtractor, $book);
            $book = self::tags($metadataExtractor, $book);
            $book = self::publisher($metadataExtractor, $book);
            $book = self::serie($metadataExtractor, $book);
            self::rawCover($metadataExtractor, $book);
            $language = Language::firstOrCreate([
                'slug' => $metadataExtractor->language,
            ]);
            $book->language()->associate($language->slug);
            $identifier = Identifier::firstOrCreate([
                'isbn'   => $metadataExtractor->identifiers->isbn,
                'isbn13' => $metadataExtractor->identifiers->isbn13,
                'doi'    => $metadataExtractor->identifiers->doi,
                'amazon' => $metadataExtractor->identifiers->amazon,
                'google' => $metadataExtractor->identifiers->google,
            ]);
            $book->identifier()->associate($identifier);
            $book->save();

            BookProvider::googleBook(identifier: $identifier, book: $book);
        }
        if (! $book) {
            $book = $bookIfExist;
        }

        return $book;
    }

    /**
     * Generate Book from MetadataExtractor
     * 
     * @param MetadataExtractor $metadataExtractor 
     * 
     * @return Book 
     */
    public static function book(MetadataExtractor $metadataExtractor): Book
    {
        return Book::firstOrCreate([
            'title'        => $metadataExtractor->title,
            'slug'         => Str::slug($metadataExtractor->title, '-'),
            'title_sort'   => $metadataExtractor->title_sort,
            'contributor'  => $metadataExtractor->contributor,
            'description'  => $metadataExtractor->description,
            'date'         => $metadataExtractor->date,
            'rights'       => $metadataExtractor->rights,
            'volume'       => $metadataExtractor->volume,
        ]);
    }

    /**
     * Generate Author[] for Book from MetadataExtractor
     * 
     * @param MetadataExtractor $metadataExtractor 
     * @param Book $book 
     * 
     * @return Book 
     */
    public static function authors(MetadataExtractor $metadataExtractor, Book $book): Book
    {
        $authors = [];
        /** @var Creator $creator */
        foreach ($metadataExtractor->creators as $key => $creator) {
            $author_name = explode(' ', $creator->name);
            $lastname = $author_name[sizeof($author_name) - 1];
            array_pop($author_name);
            $firstname = implode(' ', $author_name);
            $author = Author::firstOrCreate([
                'lastname'  => $lastname,
                'firstname' => $firstname,
                'name'      => "$firstname $lastname",
                'slug'      => Str::slug("$lastname $firstname", '-'),
                'role'      => $creator->role,
            ]);
            array_push($authors, $author);
        }
        foreach ($authors as $key => $author) {
            $book->authors()->save($author);
        }

        return $book;
    }

    /**
     * Generate Tag[] for Book from MetadataExtractor
     * 
     * @param MetadataExtractor $metadataExtractor 
     * @param Book $book 
     * 
     * @return Book 
     */
    public static function tags(MetadataExtractor $metadataExtractor, Book $book): Book
    {
        foreach ($metadataExtractor->subjects as $key => $subject) {
            $tagIfExist = Tag::whereSlug(Str::slug($subject))->first();
            $tag = null;
            if (! $tagIfExist && strlen($subject) > 1 && strlen($subject) < 30) {
                $tag = Tag::firstOrCreate([
                    'name' => $subject,
                    'slug' => Str::slug($subject),
                ]);
            }
            if (! $tag) {
                $tag = $tagIfExist;
            }

            if ($tag) {
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
        }

        return $book;
    }

    /**
     * Generate Publisher for Book from MetadataExtractor
     * 
     * @param MetadataExtractor $metadataExtractor 
     * @param Book $book 
     * 
     * @return Book 
     */
    public static function publisher(MetadataExtractor $metadataExtractor, Book $book): Book
    {
        if ($metadataExtractor->publisher) {
            $publisherIfExist = Publisher::whereSlug(Str::slug($metadataExtractor->publisher))->first();
            $publisher = null;
            if (! $publisherIfExist) {
                $publisher = Publisher::firstOrCreate([
                    'name' => $metadataExtractor->publisher,
                    'slug' => Str::slug($metadataExtractor->publisher),
                ]);
            } else {
                $publisher = $publisherIfExist;
            }

            $book->publisher()->associate($publisher);
        }

        return $book;
    }

    /**
     * Generate Serie for Book from MetadataExtractor
     * 
     * @param MetadataExtractor $metadataExtractor 
     * @param Book $book 
     * 
     * @return Book 
     */
    public static function serie(MetadataExtractor $metadataExtractor, Book $book): Book
    {
        if ($metadataExtractor->serie) {
            $serieIfExist = Serie::whereSlug(Str::slug($metadataExtractor->serie))->first();
            $serie = null;
            if (! $serieIfExist) {
                $serie = Serie::firstOrCreate([
                    'title'      => $metadataExtractor->serie,
                    'title_sort' => $metadataExtractor->serie_sort,
                    'slug'       => Str::slug($metadataExtractor->serie),
                ]);
            } else {
                $serie = $serieIfExist;
            }

            $authors_serie = [];
            foreach ($serie->authors as $key => $author) {
                array_push($authors_serie, $author->slug);
            }
            $book_authors = $book->authors;
            foreach ($book_authors as $key => $author) {
                if (! in_array($author->slug, $authors_serie)) {
                    $serie->authors()->save($author);
                }
            }

            $book->serie()->associate($serie);
        }

        return $book;
    }

    /**
     * Generate JPG for Book from MetadataExtractor, use only during generation
     * 
     * @param MetadataExtractor $metadataExtractor 
     * @param Book $book 
     */
    public static function rawCover(MetadataExtractor $metadataExtractor, Book $book)
    {
        try {
            Storage::disk('public')->put("/covers-raw/$book->id.jpg", $metadataExtractor->cover);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
