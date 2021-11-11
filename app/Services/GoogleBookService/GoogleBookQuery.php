<?php

namespace App\Services\GoogleBookService;

use App\Models\GoogleBook;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Storage;

class GoogleBookQuery
{
    public function __construct(
        public ?string $url = null,
        public ?string $model_name = null,
        public ?int $model_id = 0,
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
        public ?bool $debug = false,
    ) {
    }

    public static function create(Model $model, GoogleBookService $service): GoogleBookQuery
    {
        $query = new GoogleBookQuery();
        // @phpstan-ignore-next-line
        $query->model_id = $model->id;
        $query->model_name = $service->class;

        // @phpstan-ignore-next-line
        if ($model->identifier) {
            $identifier = $model->identifier;

            $query->isbn = $identifier->isbn ?? null;
            $query->isbn13 = $identifier->isbn13 ?? null;
            $query->debug = $service->debug;

            $query->getGoogleBookUrl();
        }

        return $query;
    }

    public function getGoogleBookUrl(): GoogleBookQuery
    {
        $isbn = $this->isbn13 ? $this->isbn13 : $this->isbn;

        if ($isbn) {
            $url = 'https://www.googleapis.com/books/v1/volumes';
            $url .= "?q=isbn:{$isbn}";
            $key = 'AIzaSyBZmN1LcbHv2IxsLu_0T3F3tN9Qc_tt6UQ';
            // $url .= "&key={$key}";

            $this->url = $url;
        }

        return $this;
    }

    /**
     * Parse Google Book API response.
     */
    public function parseResponse(Response $response): GoogleBookQuery
    {
        dump($this->url);
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
                        $this->date = new DateTime($volumeInfo->publishedDate) ?? null;
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
                                $this->retail_price_amount = intval($retailPrice->amount) ?? null;
                                $this->retail_price_currency_code = intval($retailPrice->currencyCode) ?? null;
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
     * Create GoogleBook.
     */
    public function convert(): ?GoogleBook
    {
        $book = null;
        $data = [
            $this->date,
            $this->description,
            $this->industry_identifiers,
            $this->page_count,
            $this->categories,
            $this->maturity_rating,
            $this->language,
            $this->preview_link,
            $this->publisher,
            $this->retail_price_amount,
            $this->retail_price_currency_code,
            $this->buy_link,
            $this->isbn,
            $this->isbn13,
        ];
        if (! empty($data)) {
            GoogleBook::create([
                'date' => $this->date,
                'description' => $this->description,
                'industry_identifiers' => $this->industry_identifiers ? json_encode($this->industry_identifiers) : null,
                'page_count' => $this->page_count,
                'categories' => $this->categories ? json_encode($this->categories) : null,
                'maturity_rating' => $this->maturity_rating,
                'language' => $this->language,
                'preview_link' => $this->preview_link,
                'publisher' => $this->publisher,
                'retail_price_amount' => $this->retail_price_amount,
                'retail_price_currency_code' => $this->retail_price_currency_code,
                'buy_link' => $this->buy_link,
                'isbn' => $this->isbn,
                'isbn13' => $this->isbn13,
            ])->improveBookData($this->model_id);
        }

        return $book;
    }

    public function print(mixed $response, string $directory)
    {
        $response_json = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        Storage::disk('public')->put("debug/wikipedia/{$directory}/{$this->model_id}.json", $response_json);
    }
}
