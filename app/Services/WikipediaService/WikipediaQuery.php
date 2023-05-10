<?php

namespace App\Services\WikipediaService;

use App\Services\WikipediaService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        public ?string $picture_url = null,
        public ?bool $debug = false,
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
        $query->debug = $service->debug;
        $query->search_query = $search_query;
        $query->language = $language;

        return $query;
    }

    /**
     * Build Wikipedia query URL from $search_query and $language to set $query_url.
     */
    public function getQueryUrl(): WikipediaQuery
    {
        $query = str_replace(' ', '%20', "{$this->search_query}");

        // generator search images: https://commons.wikimedia.org/w/api.php?action=query&generator=search&gsrsearch=Jul%20Maroh&gsrprop=snippet&prop=imageinfo&iiprop=url&rawcontinue&gsrnamespace=6&format=json
        // generator search: https://en.wikipedia.org/w/api.php?action=query&generator=search&gsrsearch=Baxter%20Stephen&prop=info|extracts|pageimages&format=json
        // current search: https://fr.wikipedia.org/w/api.php?action=query&list=search&srsearch=intitle:Les%20Annales%20du%20Disque-Monde&format=json
        $url = "https://{$this->language}.wikipedia.org/w/api.php?";
        $url .= 'action=query';
        $url .= '&list=search';
        $url .= "&srsearch=intitle:{$query}";
        $url .= '&format=json';

        $this->query_url = $url;

        return $this;
    }

    /**
     * Build Wikipedia page id URL from $page_id and $language to set $page_id_url.
     */
    public function getPageIdUrl(): WikipediaQuery
    {
        // current search: http://fr.wikipedia.org/w/api.php?action=query&prop=info&pageids=1340228&inprop=url&format=json&prop=info|extracts|pageimages&pithumbsize=512
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
    public function parseQueryResults(?Response $response): WikipediaQuery
    {
        $pageId = false;
        if ($response) {
            $response = $response->json();
            if ($this->debug) {
                $this->print($response, 'results');
            }

            try {
                $response = json_decode(json_encode($response));
                if (! property_exists($response, 'query')) {
                    return $this;
                }
                $search = $response->query->search;
                $search = array_slice($search, 0, 5);

                // $search_list = explode(' ', $this->search_query);

                foreach ($search as $key => $result) {
                    if (0 === $key) {
                        $pageId = $result->pageid;

                        break;
                    }
                    // if (0 < count(array_intersect(array_map('strtolower', explode(' ', $result->title)), $search_list))) {
                    //     $pageId = $result->pageid;

                    //     break;
                    // }
                    // if (str_contains($result->title, '(writer)')) {
                    //     $pageId = $result->pageid;

                    //     break;
                    // }
                    // if (str_contains($result->title, '(author)')) {
                    //     $pageId = $result->pageid;

                    //     break;
                    // }
                }

                if (! $pageId && array_key_exists(0, $search)) {
                    $pageId = $search[0]->pageid;
                }
            } catch (\Throwable $th) {
                throw $th;
            }

            if ($pageId) {
                $this->page_id = $pageId;
                $this->getPageIdUrl();
            }
        }

        return $this;
    }

    /**
     * Parse page id response to extract data.
     */
    public function parsePageIdData(?Response $response): WikipediaQuery
    {
        if (null === $response) {
            return $this;
        }
        $response = $response->json();
        if ($this->debug) {
            $this->print($response, 'page-id');
        }

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

    /**
     * Get picture from WikipediaService picture_url.
     */
    public static function getPictureFile(string|null $picture_url): string|null
    {
        $picture = null;
        if ($picture_url) {
            $picture = Http::timeout(120)->get($picture_url)->body();
        }

        return base64_encode($picture);
    }

    public static function convertExtract(string|null $text, int $limit): string
    {
        $content = '';
        if ($text) {
            $text = trim($text);
            $text = strip_tags($text);
            $text = str_replace('<<', '"', $text);
            $text = str_replace('>>', '"', $text);

            if ($limit && strlen($text) > $limit) {
                $text = substr($text, 0, $limit);
            }

            $text = trim($text);
            $text = preg_replace('/\s\s+/', ' ', $text); // remove extra break lines

            $text = htmlspecialchars($text); // convert html special chars
            $text = html_entity_decode($text); // translate html entities

            $content = $text;
        }

        return $content.'...';
    }

    public function print(mixed $response, string $directory)
    {
        $response_json = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        Storage::disk('public')->put("debug/wikipedia/{$directory}/{$this->model_id}.json", $response_json);
    }
}
