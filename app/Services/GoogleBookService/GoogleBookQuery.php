<?php

namespace App\Services\GoogleBookService;

use App\Services\GoogleBookService;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Storage;

/**
 * Create GoogleBookQuery from Model and ISBN.
 *
 * @property ?string   $original_isbn
 * @property ?string   $url
 * @property ?string   $model_name
 * @property ?int      $model_id
 * @property ?DateTime $published_date
 * @property ?string   $description
 * @property array     $industry_identifiers
 * @property ?int      $page_count
 * @property array     $categories
 * @property ?string   $maturity_rating
 * @property ?string   $language
 * @property ?string   $preview_link
 * @property ?string   $publisher
 * @property ?int      $retail_price_amount
 * @property ?int      $retail_price_currency_code
 * @property ?string   $buy_link
 * @property ?string   $isbn10
 * @property ?string   $isbn13
 * @property string[]  $isbn_available
 * @property ?bool     $debug
 */
class GoogleBookQuery
{
    public function __construct(
        public ?int $model_id = null,
        public ?string $model_name = null,
        public ?bool $debug = false,
        public array $isbn_available = [],
        public ?string $original_isbn = null,
        public ?string $url = null,
        public ?DateTime $published_date = null,
        public ?string $description = null,
        public array $industry_identifiers = [],
        public ?int $page_count = null,
        public array $categories = [],
        public ?string $maturity_rating = null,
        public ?string $language = null,
        public ?string $preview_link = null,
        public ?string $publisher = null,
        public ?int $retail_price_amount = null,
        public ?int $retail_price_currency_code = null,
        public ?string $buy_link = null,
        public ?string $isbn10 = null,
        public ?string $isbn13 = null,
    ) {
    }

    /**
     * Create new GoogleBookQuery from Model and GoogleBookService.
     */
    public static function make(object $model, GoogleBookService $service): self
    {
        $query = new GoogleBookQuery();
        $query->model_id = $model->{$service->subject_identifier} ?? null;
        $query->model_name = $service->subject ?? null;
        $query->debug = $service->debug;

        foreach ($service->isbn_fields as $field) {
            $query->isbn_available[] = $model->{$field} ?? null;
        }
        $query->isbn_available = array_filter($query->isbn_available);
        $query->setGoogleBookUrl();

        return $query;
    }

    /**
     * Build GoogleBook API url from ISBN.
     */
    public function setGoogleBookUrl(): self
    {
        $isbn = null;
        if (array_key_exists(0, $this->isbn_available)) {
            $isbn = $this->isbn_available[0];
        }

        if ($isbn) {
            $url = 'https://www.googleapis.com/books/v1/volumes';
            $url .= "?q=isbn:{$isbn}";

            $this->url = $url;
            $this->original_isbn = $isbn;
        }

        return $this;
    }

    /**
     * Parse Google Book API response.
     */
    public function parseResponse(?Response $response): self
    {
        if (null !== $response) {
            $response = $response->json();
            if ($this->debug) {
                $this->print($response, 'gbooks');
            }

            try {
                $response = json_decode(json_encode($response));

                if (property_exists($response, 'items')) {
                    $item = $response->items[0];

                    if (property_exists($item, 'volumeInfo')) {
                        $volumeInfo = $item->volumeInfo ?? null;
                        if ($volumeInfo) {
                            $this->published_date = new DateTime($volumeInfo->publishedDate);
                            $this->publisher = $volumeInfo->publisher ?? null;
                            $this->description = $volumeInfo->description ?? null;
                            $this->industry_identifiers = $volumeInfo->industryIdentifiers ?? [];
                            $this->page_count = $volumeInfo->pageCount ?? null;
                            $this->categories = $volumeInfo->categories ?? [];
                            $this->maturity_rating = $volumeInfo->maturityRating ?? null;
                            $this->language = $volumeInfo->language ?? null;
                            $this->preview_link = $volumeInfo->previewLink ?? null;
                        }
                    }

                    if (property_exists($item, 'saleInfo')) {
                        $saleInfo = $item->saleInfo;
                        if ($saleInfo) {
                            if (property_exists($saleInfo, 'retailPrice')) {
                                $retailPrice = $saleInfo->retailPrice;
                                if ($retailPrice) {
                                    $this->retail_price_amount = intval($retailPrice->amount);
                                    $this->retail_price_currency_code = intval($retailPrice->currencyCode);
                                }
                            }
                            $this->buy_link = $saleInfo->buyLink ?? null;
                        }
                    }

                    if ($this->industry_identifiers) {
                        foreach ($this->industry_identifiers as $key => $new_identifier) {
                            if ('ISBN_13' === $new_identifier->type) {
                                $this->isbn13 = $new_identifier->identifier ?? null;
                            }
                            if ('ISBN_10' === $new_identifier->type) {
                                $this->isbn10 = $new_identifier->identifier ?? null;
                            }
                        }
                    }
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        return $this;
    }

    /**
     * Print response into JSON format to debug, store it to `public/storage/debug/wikipedia/{$directory}/`.
     */
    public function print(mixed $response, string $directory)
    {
        $response_json = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        Storage::disk('public')->put("debug/wikipedia/{$directory}/{$this->model_id}.json", $response_json);
    }
}
