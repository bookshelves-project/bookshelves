<?php

namespace App\Services;

use App\Class\GoogleBook;
use App\Services\GoogleBookService\GoogleBookQuery;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;

/**
 * Use GoogleBook API to improve `$subject` data.
 *
 * @property EloquentBuilder|Relation|string  $subject            Model class name, `Book::class`.
 * @property string[]                         $isbn_fields        List of isbn fields into `$subject`
 * @property string                           $subject_identifier Unique identifier of the model, default is `id`
 * @property ?Collection<int,object>          $models             List of scanned models
 * @property ?Collection<int,GoogleBookQuery> $queries            List of queries
 * @property ?Collection<int,GoogleBookQuery> $queries_failed     List of failed queries
 * @property GoogleBook[]                     $googleBooks        List of GoogleBook items
 * @property bool                             $debug              Debug mode
 */
class GoogleBookService
{
    public function __construct(
        public mixed $subject = null,
        public string $subject_identifier = 'id',
        public ?Collection $models = null,
        public array $isbn_fields = ['isbn'],
        public ?Collection $queries = null,
        public ?Collection $queries_failed = null,
        public array $googleBooks = [],
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
     *
     * @param string $subject Model class name, `Book::class`
     * @param bool   $debug   Debug mode, default `false`
     */
    public static function make(string $subject, ?bool $debug = false): self
    {
        $service = new GoogleBookService();
        $service->subject = $subject;
        $service->debug = $debug;

        return $service;
    }

    /**
     * Scan all models to keep only available.
     *
     * @param string   $subject     Model class name, `Book::class`
     * @param string[] $isbn_fields
     */
    public static function availableModels(string $subject, array $isbn_fields = ['isbn']): Collection
    {
        $models = collect([]);
        foreach ($subject::all() as $model) {
            foreach ($isbn_fields as $field) {
                if ($model->{$field}) {
                    $models->add($model);
                    break;
                }
            }
        }

        return $models;
    }

    /**
     * Set models to scan.
     *
     * @param Collection<int,object> $models List of scanned models
     */
    public function setModels(Collection $models): self
    {
        $this->models = $models;

        return $this;
    }

    /**
     * Set isbn fields to scan.
     *
     * @param string[] $isbn_fields List of isbn fields into `$subject`, set more relevant first, default `['isbn']`
     */
    public function setIsbnFields(array $isbn_fields = ['isbn']): self
    {
        $this->isbn_fields = $isbn_fields;

        return $this;
    }

    /**
     * Set unique identifier of the model.
     *
     * @param string $subject_identifier Default is `id`
     */
    public function setSubjectIdentifier(string $subject_identifier = 'id'): self
    {
        $this->subject_identifier = $subject_identifier;

        return $this;
    }

    /**
     * Execute GoogleBookService.
     */
    public function execute(): self
    {
        if (null === $this->models) {
            $this->models = self::availableModels($this->subject, $this->isbn_fields);
        }

        $this->search();

        return $this;
    }

    /**
     * Make GET request from GoogleBook API and parse it.
     */
    private function search(): self
    {
        $this->queries();

        /**
         * Make GET request from $url_attribute of GoogleBookQuery[].
         */
        $responses = HttpService::getCollection($this->queries, 'url', 'model_id');

        $queries = collect([]);
        $failed = collect([]);
        // Parse Reponse[] with $method
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

        $this->convert();

        return $this;
    }

    /**
     * Create `GoogleBook[]` from `GoogleBookQuery[]`.
     */
    private function convert(): self
    {
        /** @var GoogleBookQuery $query */
        foreach ($this->queries as $query) {
            $this->googleBooks[] = new GoogleBook(
                model_id: $query->model_id,
                model_name: $query->model_name,
                original_isbn: $query->original_isbn,
                url: $query->url,
                published_date: $query->published_date,
                description: $query->description,
                industry_identifiers: $query->industry_identifiers,
                page_count: $query->page_count,
                categories: $query->categories,
                maturity_rating: $query->maturity_rating,
                language: $query->language,
                preview_link: $query->preview_link,
                publisher: $query->publisher,
                retail_price_amount: $query->retail_price_amount,
                retail_price_currency_code: $query->retail_price_currency_code,
                buy_link: $query->buy_link,
                isbn10: $query->isbn10,
                isbn13: $query->isbn13,
            );
        }

        return $this;
    }

    private function queries(): self
    {
        foreach ($this->models as $model) {
            $query = GoogleBookQuery::make($model, $this);

            $this->queries->add($query);
        }

        return $this;
    }
}
