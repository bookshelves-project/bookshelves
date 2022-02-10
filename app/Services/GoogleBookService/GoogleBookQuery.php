<?php

namespace App\Services\GoogleBookService;

use App\Models\Book;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Storage;

class GoogleBookQuery
{
    public function __construct(
        public ?string $original_isbn = null,
        public ?string $url = null,
        public ?string $model_name = null,
        public ?int $model_id = 0,
        public ?DateTime $published_date = null,
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
        public ?bool $debug = false,
    ) {
    }

    /**
     * Create new GoogleBookQuery from Model and GoogleBookService.
     */
    public static function create(Model $model, GoogleBookService $service): GoogleBookQuery
    {
        $query = new GoogleBookQuery();
        // @phpstan-ignore-next-line
        $query->model_id = $model->id;
        $query->model_name = $service->class;

        /** @var Book $model */
        if ($model->isbn) {
            $query->isbn = $model->identifier_isbn ?? null;
            $query->isbn13 = $model->identifier_isbn13 ?? null;
            $query->debug = $service->debug;

            $query->getGoogleBookUrl();
        }

        return $query;
    }

    /**
     * Build GoogleBook API url from ISBN.
     */
    public function getGoogleBookUrl(): GoogleBookQuery
    {
        $isbn = $this->isbn13 ? $this->isbn13 : $this->isbn;

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
    public function parseResponse(Response $response): GoogleBookQuery
    {
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
                        $this->industry_identifiers = $volumeInfo->industryIdentifiers ?? null;
                        $this->page_count = $volumeInfo->pageCount ?? null;
                        $this->categories = $volumeInfo->categories ?? null;
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
                            $this->isbn = $new_identifier->identifier ?? null;
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            throw $th;
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
