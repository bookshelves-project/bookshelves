<?php

namespace App\Services\WikipediaService;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;
use Storage;

class WikipediaQuery
{
    public function __construct(
        public ?string $model_name = null,
        public ?int $model_id = 0,
        public ?string $language = 'en',
        public ?string $search_query = null,
        public ?string $query_url = null,
        public ?string $page_id = null,
        public ?string $page_id_url = null,
        public ?string $page_url = null,
        public ?string $extract = null,
        public ?string $picture_url = null
    ) {
    }

    /**
     * Create WikipediaQuery from $search_query, $model_id, $language and WikipediaService.
     */
    public static function create(string $search_query, int $model_id, string $language, WikipediaService $service): WikipediaQuery
    {
        $query = new WikipediaQuery();
        $query->model_name = $service->class;
        $query->model_id = $model_id;
        $query->search_query = $search_query;
        $query->language = $language;

        return $query;
    }

    /**
     * Build Wikipedia query URL from $search_query and $language to set $query_url.
     */
    public function getQueryUrl(): WikipediaQuery
    {
        $query = str_replace(' ', '%20', $this->search_query);

        $url = "https://{$this->language}.wikipedia.org/w/api.php?";
        $url .= 'action=query';
        $url .= '&list=search';
        $url .= "&srsearch={$query}";
        $url .= '&format=json';

        $this->query_url = $url;

        return $this;
    }

    /**
     * Build Wikipedia page id URL from $page_id and $language to set $page_id_url.
     */
    public function getPageIdUrl(): WikipediaQuery
    {
        $url = "http://{$this->language}.wikipedia.org/w/api.php?";
        $url .= 'action=query';
        $url .= '&prop=info';
        $url .= "&pageids={$this->page_id}";
        $url .= '&inprop=url';
        $url .= '&format=json';
        $url .= '&prop=info|extracts|pageimages';
        $url .= '&pithumbsize=512';

        $this->page_id_url = $url;

        return $this;
    }

    /**
     * Find page id among Wikipedia results, if found set $page_id_url.
     */
    public function parseQueryResults(Response $response): WikipediaQuery
    {
        $pageId = false;
        $results = $response->json();
        $search = null;
        // try to get writer
        if (array_key_exists('query', $results) && array_key_exists('search', $results['query'])) {
            $search = $results['query']['search'];
            // keep first results
            $search = array_slice($search, 0, 5);
            // search if writer exist
            foreach ($search as $key => $result) {
                if (strpos($result['title'], '(writer)')) {
                    $pageId = $result['pageid'];

                    break;
                }
            }
        }
        // default method: first result
        if (! $pageId && array_key_exists(0, $search)) {
            $pageId = $search[0]['pageid'];
        }

        if ($pageId) {
            $this->page_id = $pageId;
            $this->getPageIdUrl();
        }

        return $this;
    }

    /**
     * Parse page id response to extract data.
     */
    public function parsePageIdData(Response $response): WikipediaQuery
    {
        $response = $response->json();

        $response_json = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        Storage::disk('public')->put("debug/wikipedia/{$this->model_id}.json", $response_json);

        try {
            $response = json_decode(json_encode($response));
            $page = $response?->query?->pages;
            $page = reset($page);

            $this->extract = $this->convertExtract($page->extract, 2000);
            $this->picture_url = $page->thumbnail?->source ?? null;
            $this->page_url = $page->fullurl ?? null;
        } catch (\Throwable $th) {
            throw $th;
        }

        return $this;
    }

    public static function convertExtract(string|null $text, int $limit): string
    {
        $content = '';
        if ($text) {
            $isUTF8 = mb_check_encoding($text, 'UTF-8');
            $content = iconv('UTF-8', 'UTF-8//IGNORE', $text);

            if ($isUTF8) {
                $content = trim($content);
                if ($limit && strlen($content) > $limit) {
                    $content = substr($content, 0, $limit);
                }
                $content = strip_tags($content);
                $content = Str::ascii($content);
                $content = str_replace('<<', '"', $content);
                $content = str_replace('>>', '"', $content);
                $content = trim($content);
                $content = preg_replace('/\\([^)]+\\)/', '', $content);
                $content = preg_replace('/\s\s+/', ' ', $content);
            }
        }

        return $content.'...';
    }
}
