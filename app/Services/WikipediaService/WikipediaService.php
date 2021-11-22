<?php

namespace App\Services\WikipediaService;

use App\Models\Wikipedia;
use App\Models\WikipediaItem;
use App\Services\ConsoleService;
use App\Services\HttpService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Use Wikipedia to get some data about authors and series.
 * Doc in french: https://korben.info/comment-utiliser-lapi-de-recherche-de-wikipedia.html.
 *
 * For each Wikipedia search, need to execute two API calls to search to get page id and to parse page id data.
 */
class WikipediaService
{
    public function __construct(
        public ?string $class = null,
        public ?Collection $models = null,
        public ?string $query_attribute = null,
        public ?string $language_attribute = null,
        public ?Collection $queries = null,
        public ?Collection $queries_failed = null,
        public ?Collection $items = null,
        public ?bool $debug = false,
    ) {
        $this->models = collect([]);
        $this->queries = collect([]);
        $this->queries_failed = collect([]);
        $this->items = collect([]);
    }

    /**
     * Create WikipediaService from Model and create WikipediaQuery for each entity only if hasn't WikipediaItem.
     */
    public static function create(string $class, string $attribute, ?string $language_attribute = 'language_slug', ?bool $debug = false): WikipediaService
    {
        $service = new WikipediaService();
        $service->class = $class;
        $models = $class::all();
        /**
         * Keep only books without wikipedia relation.
         */
        foreach ($models as $model) {
            if (! $model->wikipedia) {
                $service->models->add($model);
            }
        }
        $service->query_attribute = $attribute;
        $service->language_attribute = $language_attribute;
        $service->debug = $debug;

        $service->getWikipediaQueries();

        ConsoleService::print('List of query URL available.');
        ConsoleService::print('Requests from query URL to get page id.', true);

        $service->search('query_url', 'parseQueryResults');

        ConsoleService::print('List of page id URL available.');
        ConsoleService::print('Requests from page id URL to get extra content.', true);

        $service->search('page_id_url', 'parsePageIdData');

        ConsoleService::print('Convert into WikipediaItem...');

        $service->convert();

        return $service;
    }

    /**
     * Get WikipediaQuery for each $models.
     */
    public function getWikipediaQueries(): WikipediaService
    {
        /** @var Model $model */
        foreach ($this->models as $model) {
            /**
             * It's necessary to have a query attribute to search on Wikipedia and an ID to refer to model.
             */
            if (array_key_exists($this->query_attribute, $model->getAttributes()) && array_key_exists('id', $model->getAttributes())) {
                /**
                 * If language attribute is unknown, set it to english.
                 */
                $lang = array_key_exists($this->language_attribute, $model->getAttributes()) ? $model->{$this->language_attribute} : 'en';

                $query = $model->{$this->query_attribute};

                // @phpstan-ignore-next-line
                $query = WikipediaQuery::create($query, $model->id, $lang, $this)
                    ->getQueryUrl()
                ;

                $this->queries->add($query);
            } else {
                throw new Exception("This model don't have attributes: {$this->query_attribute},id.");
            }
        }

        return $this;
    }

    /**
     * Make GET request from Wikipedia API and parse it.
     *
     * @param string $url_attribute is WikipediaQuery attribute which is an URL
     * @param string $method        is WikipediaQuery class method to parse response
     */
    public function search(string $url_attribute, string $method): WikipediaService
    {
        /**
         * Make GET request from $url_attribute of WikipediaQuery[].
         */
        $responses = HttpService::getCollection($this->queries, $url_attribute, 'model_id');

        $queries = collect([]);
        $failed = collect([]);
        /** Parse Reponse[] with $method */
        foreach ($responses as $id => $response) {
            /** @var null|WikipediaQuery $query */
            $query = $this->queries->first(fn (WikipediaQuery $query) => $query->model_id === $id);
            if (null !== $query) {
                $query = $query->{$method}($response);
                $queries->add($query);
            } else {
                $failed->add($id);
            }
        }

        $this->queries = $queries;
        $this->queries_failed = $failed;

        return $this;
    }

    /**
     * Create WikipediaItem and associate with model.
     */
    public function convert(): WikipediaService
    {
        /** @var WikipediaQuery $query */
        foreach ($this->queries as $query) {
            $item = WikipediaItem::create([
                'model' => $query->model_name,
                'language' => $query->language,
                'search_query' => $query->search_query,
                'query_url' => $query->query_url,
                'page_id' => $query->page_id,
                'page_id_url' => $query->page_id_url,
                'page_url' => $query->page_url,
                'extract' => $query->extract,
                'picture_url' => $query->picture_url,
            ]);
            $model = $query->model_name::find($query->model_id);
            $model->wikipedia()->associate($item);
            $model->save();
        }

        return $this;
    }
}
