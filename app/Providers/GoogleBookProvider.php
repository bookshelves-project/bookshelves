<?php

namespace App\Providers;

use DateTime;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\GoogleBook;
use App\Models\Identifier;
use App\Utils\BookshelvesTools;
use Illuminate\Support\Facades\Http;

/**
 * @method $this create() get Google Book API data from ISBN or ISBN13
 * @method $this convert() Create GoogleBook
 * @package App\Providers
 */
class GoogleBookProvider
{
    public function __construct(
        public Book $book,
        public ?string $original_isbn = null,
        public ?string $original_isbn13 = null,
        public string $url,
        public ?DateTime $date = null,
        public ?string $description = null,
        public ?array $industry_identifiers = null,
        public ?int $page_count = null,
        public ?array $categories = null,
        public ?string $maturity_rating = null,
        public ?string $language = null,
        public ?string $preview_link = null,
        public ?string $publisher = null,
        public ?int $retail_price_amount = null,
        public ?int $retail_price_currency_code = null,
        public ?string $buy_link = null,
        public ?string $isbn = null,
        public ?string $isbn13 = null,
    ) {
    }

    /**
     * Get data from Google Books API with ISBN from meta
     * Example: https://www.googleapis.com/books/v1/volumes?q=isbn:9782700239904.
     *
     * Get all useful data to improve Book, Identifier, Publisher and Tag
     * If data exist, create GoogleBook associate with Book with useful data to purchase eBook
     */
    public static function create(Book $book): GoogleBookProvider
    {
        $identifier = $book->identifier;
        $original_isbn = $identifier->isbn ?? null;
        $original_isbn13 = $identifier->isbn13 ?? null;
        if ($original_isbn13) {
            $isbn = $original_isbn13;
        } elseif ($original_isbn) {
            $isbn = $original_isbn;
        }
        $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn";
        $gbook = new GoogleBookProvider($book, $original_isbn, $original_isbn13, $url);

        if ($isbn) {
            try {
                $response = Http::get($url);
                $response = $response->json();

                if (array_key_exists('items', $response)) {
                    $response = $response['items'][0];
                    $data = $response['volumeInfo'];
                    if (array_key_exists('volumeInfo', $response)) {
                        $gbook->date = new DateTime($data['publishedDate']);
                        $gbook->publisher = array_key_exists('publisher', $data) ? $data['publisher'] : null;
                        $gbook->description = array_key_exists('description', $data) ? $data['description'] : null;
                        $gbook->industry_identifiers = array_key_exists('industryIdentifiers', $data) ? $data['industryIdentifiers'] : null;
                        $gbook->page_count = array_key_exists('pageCount', $data) ? $data['pageCount'] : null;
                        $gbook->categories = array_key_exists('categories', $data) ? $data['categories'] : null;
                        $gbook->maturity_rating = array_key_exists('maturityRating', $data) ? $data['maturityRating'] : null;
                        $gbook->language = array_key_exists('language', $data) ? $data['language'] : null;
                        $gbook->preview_link = array_key_exists('previewLink', $data) ? $data['previewLink'] : null;
                    }

                    $sale_data = $response['saleInfo'];
                    if (array_key_exists('saleInfo', $response)) {
                        // $gbook->is_ebook = (bool) $sale_data['isEbook'];
                        if (array_key_exists('retailPrice', $sale_data)) {
                            $gbook->retail_price_amount = intval($sale_data['retailPrice']['amount']);
                            $gbook->retail_price_currency_code = intval($sale_data['retailPrice']['currencyCode']);
                        }
                        $gbook->buy_link = array_key_exists('buyLink', $sale_data) ? $sale_data['buyLink'] : null;
                    }

                    if ($gbook->industry_identifiers) {
                        foreach ($gbook->industry_identifiers as $key => $new_identifier) {
                            if ('ISBN_13' === $new_identifier['type']) {
                                $gbook->isbn13 = $new_identifier['identifier'];
                            }
                            if ('ISBN_10' === $new_identifier['type']) {
                                $gbook->isbn = $new_identifier['identifier'];
                            }
                        }
                    }
                }
            } catch (\Throwable $th) {
                BookshelvesTools::console(__METHOD__, $th);
            }
        }

        return $gbook;
    }

    /**
     * Create GoogleBook
     */
    public function convert(): GoogleBook
    {
        $googleBook = GoogleBook::create([
            'date'                       => $this->date,
            'description'                => $this->description,
            'industry_identifiers'       => json_encode($this->industry_identifiers),
            'page_count'                 => $this->page_count,
            'categories'                 => json_encode($this->categories),
            'maturity_rating'            => $this->maturity_rating,
            'language'                   => $this->language,
            'preview_link'               => $this->preview_link,
            'publisher'                  => $this->publisher,
            'retail_price_amount'        => $this->retail_price_amount,
            'retail_price_currency_code' => $this->retail_price_currency_code,
            'buy_link'                   => $this->buy_link,
            'isbn'                       => $this->isbn,
            'isbn13'                     => $this->isbn13,
        ]);
        $googleBook->book()->save($this->book);

        return $googleBook;
    }
}
