<?php

namespace App\Services;

use App\Models\Book;
use App\Models\GoogleBook;
use App\Models\Identifier;
use App\Models\Publisher;
use App\Utils\BookshelvesTools;
use App\Utils\HttpTools;
use DateTime;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * @method $this create()  get Google Book API data from ISBN or ISBN13
 * @method $this convert() Create GoogleBook
 */
class GoogleBookService
{
    public function __construct(
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
     * Async Google Book API calls.
     *
     * @return GoogleBookService[]
     */
    public static function createAsync(Collection $books): array
    {
        $urlList = [];
        foreach ($books as $key => $book) {
            $url = self::setIsbn($book);
            $urlList[$book->id] = $url;
        }
        $responses = HttpTools::async($urlList);

        $providers = [];
        foreach ($responses as $bookID => $response) {
            $provider = self::setData($response);
            $providers[$bookID] = $provider;
        }

        return $providers;
    }

    /**
     * Get data from Google Books API with ISBN from meta
     * Example: https://www.googleapis.com/books/v1/volumes?q=isbn:9782700239904.
     *
     * Get all useful data to improve Book, Identifier, Publisher and Tag
     * If data exist, create GoogleBook associate with Book with useful data to purchase eBook
     */
    public static function create(Book $book): GoogleBookService
    {
        $url = self::setIsbn($book);

        if ($url) {
            try {
                $response = Http::get($url);
                $provider = self::setData($response);
            } catch (\Throwable $th) {
                BookshelvesTools::console(__METHOD__, $th);
            }
        }

        return $provider ?? null;
    }

    public static function setIsbn(Book $book): string|false
    {
        $identifier = $book->identifier;
        $original_isbn = $identifier->isbn ?? null;
        $original_isbn13 = $identifier->isbn13 ?? null;

        $isbn = null;
        $url = false;
        if ($original_isbn13) {
            $isbn = $original_isbn13;
        } elseif ($original_isbn) {
            $isbn = $original_isbn;
        }
        if ($isbn) {
            $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:{$isbn}";
        }

        return $url;
    }

    public static function setData(Response $response): GoogleBookService
    {
        // @phpstan-ignore-next-line
        $url = $response->transferStats->getRequest()->getUri()->getQuery();
        $provider = new GoogleBookService($url);
        $response = $response->json();

        if (array_key_exists('items', $response)) {
            $response = $response['items'][0];
            $data = $response['volumeInfo'];
            if (array_key_exists('volumeInfo', $response)) {
                $provider->date = new DateTime($data['publishedDate']);
                $provider->publisher = array_key_exists('publisher', $data) ? $data['publisher'] : null;
                $provider->description = array_key_exists('description', $data) ? $data['description'] : null;
                $provider->industry_identifiers = array_key_exists('industryIdentifiers', $data) ? $data['industryIdentifiers'] : null;
                $provider->page_count = array_key_exists('pageCount', $data) ? $data['pageCount'] : null;
                $provider->categories = array_key_exists('categories', $data) ? $data['categories'] : null;
                $provider->maturity_rating = array_key_exists('maturityRating', $data) ? $data['maturityRating'] : null;
                $provider->language = array_key_exists('language', $data) ? $data['language'] : null;
                $provider->preview_link = array_key_exists('previewLink', $data) ? $data['previewLink'] : null;
            }

            $sale_data = $response['saleInfo'];
            if (array_key_exists('saleInfo', $response)) {
                // $provider->is_ebook = (bool) $sale_data['isEbook'];
                if (array_key_exists('retailPrice', $sale_data)) {
                    $provider->retail_price_amount = intval($sale_data['retailPrice']['amount']);
                    $provider->retail_price_currency_code = intval($sale_data['retailPrice']['currencyCode']);
                }
                $provider->buy_link = array_key_exists('buyLink', $sale_data) ? $sale_data['buyLink'] : null;
            }

            if ($provider->industry_identifiers) {
                foreach ($provider->industry_identifiers as $key => $new_identifier) {
                    if ('ISBN_13' === $new_identifier['type']) {
                        $provider->isbn13 = $new_identifier['identifier'];
                    }
                    if ('ISBN_10' === $new_identifier['type']) {
                        $provider->isbn = $new_identifier['identifier'];
                    }
                }
            }
        }

        return $provider;
    }

    /**
     * Create GoogleBook.
     */
    public function convert(): GoogleBook
    {
        return GoogleBook::create([
            'date' => $this->date,
            'description' => $this->description,
            'industry_identifiers' => json_encode($this->industry_identifiers),
            'page_count' => $this->page_count,
            'categories' => json_encode($this->categories),
            'maturity_rating' => $this->maturity_rating,
            'language' => $this->language,
            'preview_link' => $this->preview_link,
            'publisher' => $this->publisher,
            'retail_price_amount' => $this->retail_price_amount,
            'retail_price_currency_code' => $this->retail_price_currency_code,
            'buy_link' => $this->buy_link,
            'isbn' => $this->isbn,
            'isbn13' => $this->isbn13,
        ]);
    }
}
