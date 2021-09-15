<?php

namespace App\Providers\BookshelvesConverter;

use Illuminate\Support\Facades\Http;

class WikipediaProvider
{
    public function __construct(
        public string $query,
        public ?string $pageId = null,
        public array $response,
        public ?string $extract = null,
        public ?string $page_url = null,
        public ?string $picture_url = null
    ) {
    }

    /**
     *
     * @return WikipediaProvider
     */
    public static function create(string $query, string $lang = 'en', bool $debug = false)
    {
        $pageId = null;
        $response = null;
        $extract = null;
        $page_url = null;
        $picture_url = null;
        $query = str_replace(' ', '%20', $query);
        $wiki_url_query = "https://$lang.wikipedia.org/w/api.php?action=query&list=search&srsearch=$query&format=json";

        try {
            $results = Http::get($wiki_url_query);
            $results = $results->json();
            $search = $results['query']['search'];
            $search = array_slice($search, 0, 5);
            foreach ($search as $key => $result) {
                if (strpos($result['title'], '(writer)')) {
                    $pageId = $result['pageid'];

                    break;
                }
            }
            if (! $pageId && array_key_exists(0, $search)) {
                $pageId = $search[0]['pageid'];
            }

            try {
                $wiki_url_page_id = "http://$lang.wikipedia.org/w/api.php?action=query&prop=info&pageids=$pageId&inprop=url&format=json&prop=info|extracts|pageimages&pithumbsize=512";

                if ($debug) {
                    echo $wiki_url_page_id . "\n";
                }
                $response = Http::get($wiki_url_page_id);
                $response = $response->json();

                $page = $response['query']['pages'][$pageId];
                $extract = $page['extract'];

                try {
                    $picture_url = $page['thumbnail']['source'];
                } catch (\Throwable $th) {
                    if ($debug) {
                        echo "No picture for " . $query . "\n";
                    }
                }

                try {
                    $page_url = $page['fullurl'];
                    $extract = $page['extract'];
                } catch (\Throwable $th) {
                    if ($debug) {
                        echo "No extract for " . $query . "\n";
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                if ($debug) {
                    echo "\nError on response/page for $query\n";
                }
            }
        } catch (\Throwable $th) {
            if ($debug) {
                echo "\nNo wikipedia page for $query\n";
            }
        }

        $wiki = new WikipediaProvider($query, $pageId, $response, $extract, $page_url, $picture_url);

        return $wiki;
    }

    public static function getPictureFile(WikipediaProvider $wikipediaProvider, bool $debug = false): string | null
    {
        $picture = null;
        try {
            $picture = Http::get($wikipediaProvider->picture_url)->body();
        } catch (\Throwable $th) {
            if ($debug) {
                echo "\nNo wikipedia picture_url for $wikipediaProvider->query\n";
            }
        }

        return $picture;
    }
}
