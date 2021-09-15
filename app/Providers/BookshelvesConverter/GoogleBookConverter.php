<?php

namespace App\Providers\BookshelvesConverter;

use DateTime;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\GoogleBook;
use App\Models\Identifier;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class GoogleBookConverter
{
    /**
     * Get data from Google Books API with ISBN from meta
     * Example: https://www.googleapis.com/books/v1/volumes?q=isbn:9782700239904.
     *
     * Get all useful data to improve Book, Identifier, Publisher and Tag
     * If data exist, create GoogleBook associate with Book with useful data to purchase eBook
     */
    public static function create(Identifier $identifier, Book $book): Book
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
                    TagConverter::tagRaw($category, $book);
                }
            } catch (\Throwable $th) {
            }

            ! $book->date && $date ? $book->date = $date : null;
            ! $book->description && $description ? $book->description = $description : null;
            ! $book->page_count && $pageCount ? $book->page_count = $pageCount : null;
            ! $book->maturity_rating && $maturityRating ? $book->maturity_rating = $maturityRating : null;
            if (! $book->publisher && $publisher) {
                $publisher = Publisher::firstOrCreate([
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
