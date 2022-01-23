<?php

namespace App\Services\GoogleBookService;

use App\Models\GoogleBook;
use App\Services\HttpService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class GoogleBookService
{
    public function __construct(
        public ?string $class = null,
        public ?Collection $models = null,
        public ?Collection $queries = null,
        public ?Collection $queries_failed = null,
        public ?bool $debug = false,
    ) {
        $this->models = collect([]);
        $this->queries = collect([]);
        $this->queries_failed = collect([]);
    }

    /**
     * Get data from Google Books API with ISBN from meta
     * Example: https://www.googleapis.com/books/v1/volumes?q=isbn:9782700239904.
     *
     * Get all useful data to improve Book, Identifier, Publisher and Tag
     * If data exist, create GoogleBook associate with Book with useful data to purchase eBook
     */
    public static function create(string $class, ?bool $debug = false): GoogleBookService
    {
        $service = new GoogleBookService();
        $service->class = $class;
        $models = $class::all();
        /*
         * Keep only books without googleBook relation.
         */
        foreach ($models as $model) {
            if (! $model->googleBook) {
                $service->models->add($model);
            }
        }
        $service->debug = $debug;

        $service->getQueries()
            ->search()
            ->convert()
        ;

        return $service;
    }

    public function getQueries(): GoogleBookService
    {
        /** @var Model $model */
        foreach ($this->models as $model) {
            $query = GoogleBookQuery::create($model, $this);

            $this->queries->add($query);
        }

        return $this;
    }

    /**
     * Make GET request from Wikipedia API and parse it.
     */
    public function search(): GoogleBookService
    {
        /**
         * Make GET request from $url_attribute of GoogleBookQuery[].
         */
        $responses = HttpService::getCollection($this->queries, 'url', 'model_id');

        $queries = collect([]);
        $failed = collect([]);
        /* Parse Reponse[] with $method */
        foreach ($responses as $id => $response) {
            /** @var null|GoogleBookQuery $query */
            $query = $this->queries->first(fn (GoogleBookQuery $query) => $query->model_id === $id);
            if (null !== $query) {
                $query = $query->parseResponse($response);
                $queries->add($query);
            } else {
                $failed->add($id);
            }
        }

        $this->queries->replace($queries);
        $this->queries_failed->replace($failed);

        return $this;
    }

    /**
     * Create GoogleBook and associate with model.
     */
    public function convert(): GoogleBookService
    {
        /** @var GoogleBookQuery $query */
        foreach ($this->queries as $query) {
            /** @var string[] $data */
            $data = [
                'date' => $query->date,
                'description' => $query->description,
                'industry_identifiers' => $query->industry_identifiers ? json_encode($query->industry_identifiers) : null,
                'page_count' => $query->page_count,
                'categories' => $query->categories ? json_encode($query->categories) : null,
                'maturity_rating' => $query->maturity_rating,
                'language' => $query->language,
                'preview_link' => $query->preview_link,
                'publisher' => $query->publisher,
                'retail_price_amount' => $query->retail_price_amount,
                'retail_price_currency_code' => $query->retail_price_currency_code,
                'buy_link' => $query->buy_link,
                'isbn' => $query->isbn,
                'isbn13' => $query->isbn13,
            ];
            // $is_null = empty(array_filter($data, fn ($el) => null !== $el));
            // if (! $is_null) {
            //     GoogleBook::create($data)
            //         ->improveBookData($this->model_id)
            //     ;
            // }
            $item = GoogleBook::create($data);
            $model = $query->model_name::find($query->model_id);
            $model->googleBook()->associate($item);
            $model->save();
        }

        return $this;
    }
}
