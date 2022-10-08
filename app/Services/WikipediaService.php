<?php

namespace App\Services;

use App\Class\WikipediaItem;
use App\Services\WikipediaService\WikipediaQuery;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ReflectionClass;

/**
 * Use Wikipedia to get some data about authors and series.
 * Doc in french: https://korben.info/comment-utiliser-lapi-de-recherche-de-wikipedia.html.
 *
 * For each Wikipedia search, need to execute two API calls to search to get page id and to parse page id data.
 *
 * @property EloquentBuilder|Relation|string $subject            Model class name, `Author::class`.
 * @property string                          $subject_identifier Unique identifier for Model, default is `id`
 * @property ?Collection<int,Model>          $models             List of scanned models
 * @property string[]                        $query_attributes   Attributes to search in Wikipedia, can be multiple for concat search
 * @property ?string                         $language           Wikipedia instance language
 * @property ?Collection<int,WikipediaQuery> $queries            List of queries
 * @property ?Collection<int,WikipediaQuery> $queries_failed     List of failed queries
 * @property ?Collection<int,WikipediaItem>  $wikipediaItems     List of WikipediaItem items
 * @property ?bool                           $debug              default `false`
 */
class WikipediaService
{
    public function __construct(
        public mixed $subject = null,
        public string $subject_identifier = 'id',
        public ?Collection $models = null,
        public array $query_attributes = ['name'],
        public ?string $language_field = null,
        public ?Collection $queries = null,
        public ?Collection $queries_failed = null,
        public ?Collection $wikipediaItems = null,
        public ?bool $debug = false,
    ) {
        $this->models = collect([]);
        $this->queries = collect([]);
        $this->queries_failed = collect([]);
        $this->wikipediaItems = collect([]);
    }

    /**
     * Create WikipediaService from Model and create WikipediaQuery for each entity only if hasn't WikipediaItem.
     */
    public static function make(string $subject, ?bool $debug = false): self
    {
        $service = new WikipediaService();

        $instance = new $subject();
        $subject = new ReflectionClass($instance);

        $service->subject = $subject->getName();
        $service->debug = $debug;

        return $service;
    }

    public function fetchModels(): self
    {
        /** @var Collection<int,Model> */
        $models = $this->subject::all();
        $this->models = $models;

        return $this;
    }

    /**
     * Set attributes to search on Wikipedia, can be unique or multiple for concat search.
     *
     * @param string|string[] $attributes
     */
    public function setQueryAttributes(mixed $attributes = ['name']): self
    {
        $list = [];
        if (is_string($attributes)) {
            $list[] = $attributes;
        } else {
            $list = $attributes;
        }

        $this->query_attributes = $list;

        return $this;
    }

    /**
     * Set language to use for Wikipedia search instance.
     */
    public function setLanguageField(string $language_field): self
    {
        $this->language_field = $language_field;

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
     * Execute WikipediaService.
     */
    public function execute(): self
    {
        $this->fetchModels();
        foreach ($this->models as $model) {
            $query = $this->wikipediaQuery($model);
            $this->queries->add($query);
        }

        ConsoleService::print('List of query URL available, requests from query URL to get page id.');
        ConsoleService::newLine();

        $this->search('query_url', 'parseQueryResults');

        ConsoleService::print('List of page id URL available, requests from page id URL to get extra content.');
        ConsoleService::newLine();

        $this->search('page_id_url', 'parsePageIdData');

        ConsoleService::print('Convert into WikipediaItem...');

        $this->convert();

        return $this;
    }

    /**
     * Create `WikipediaItem[]` from `WikipediaQuery[]`.
     */
    private function convert(): self
    {
        /** @var WikipediaQuery $query */
        foreach ($this->queries as $query) {
            $wikipediaItem = new WikipediaItem(
                model_id: $query->model_id,
                model_name: $query->model_name,
                language: $query->language,
                search_query: $query->search_query,
                query_url: $query->query_url,
                page_id: $query->page_id,
                page_id_url: $query->page_id_url,
                page_url: $query->page_url,
                extract: $query->extract,
                picture_url: $query->picture_url,
            );
            $this->wikipediaItems->add($wikipediaItem);
        }

        return $this;
    }

    /**
     * Make GET request from Wikipedia API and parse it.
     *
     * @param string $url_attribute is WikipediaQuery attribute which is an URL
     * @param string $method        is WikipediaQuery class method to parse response
     */
    private function search(string $url_attribute, string $method): self
    {
        /**
         * Make GET request from $url_attribute of WikipediaQuery[].
         */
        $responses = HttpService::getCollection($this->queries, $url_attribute, 'model_id');

        $queries = collect([]);
        $failed = collect([]);
        // Parse Reponse[] with $method
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
     * Get WikipediaQuery for each `$models`.
     */
    private function wikipediaQuery(Model $model): WikipediaQuery|false
    {
        $exist = true;

        // Test each attribute
        foreach ($this->query_attributes as $attribute) {
            if (! $this->attributeExistInModel($attribute, $model)) {
                return false;
            }
        }

        $lang = 'en';
        // If language attribute is unknown, set it to english.
        if ($this->attributeExistInModel($this->language_field, $model)) {
            $lang = $model->{$this->language_field};
            if ('unknown' === $lang || null === $lang) {
                $lang = 'en';
            }
        }

        // set query string from `$query_attributes`
        $query_string = null;
        foreach ($this->query_attributes as $attr) {
            $query_string .= $model->{$attr}.' ';
        }
        $query_string = trim($query_string);

        return WikipediaQuery::make($query_string, $model, $this->debug)
            ->setSubjectIdentifier($this->subject_identifier)
            ->setLanguage($lang)
            ->execute()
        ;
    }

    /**
     * Check if attribute exist into Model.
     */
    private function attributeExistInModel(string $attribute, Model $model): bool
    {
        return array_key_exists($attribute, $model->getAttributes());
    }
}
