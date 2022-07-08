<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlFactory;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class HttpService
{
    public const MAX_CURL_HANDLES = 100;

    public const MAX_REDIRECTS = 10;

    public const REQUEST_TIMEOUT = 30;

    public const GUZZLE_CONCURRENCY = 5;

    /**
     * Transform Collection to URL array with Model $id as key and $url_attribute as value, make GET request on each url.
     *
     * @return Response[]
     */
    public static function getCollection(Collection $collection, string $url_attribute, string $id): array
    {
        Artisan::call('cache:clear');

        $url_list = [];

        foreach ($collection as $item) {
            $url_list[$item->{$id}] = $item->{$url_attribute};
        }

        /** @var Response[] $responses_list */
        $responses_list = [];

        if (config('http.async_allow')) {
            /**
             * Chunk by limit into arrays.
             */
            $limit = config('http.pool_limit');
            $size = count($url_list);
            $chunk = array_chunk($url_list, $limit, true);
            $chunk_size = count($chunk);
            if ($size > 0) {
                ConsoleService::print('HttpService will setup async requests...');
                ConsoleService::print("Pool is limited to {$limit} from .env, {$size} requests will become {$chunk_size} chunks.");
                ConsoleService::newLine();
            }

            /**
             * async query on each chunk.
             *
             * @var array $limited_url_list
             */
            foreach ($chunk as $chunk_key => $limited_url_list) {
                $size_list = count($limited_url_list);
                $current_chunk = $chunk_key + 1;
                ConsoleService::print("Execute {$size_list} requests from chunk {$current_chunk}...");
                $responses = self::pool($limited_url_list);
                foreach ($responses as $key => $response) {
                    $responses_list[$key] = $response;
                }
            }
        } else {
            foreach ($url_list as $id => $url) {
                $responses_list[$id] = Http::timeout(120)->get($url);
            }
        }

        return $responses_list;
    }

    /**
     * Create and make request GET from array of $urls.
     */
    public static function pool(array $urls): Collection
    {
        if (extension_loaded('curl')) {
            $handler = HandlerStack::create(
                new CurlMultiHandler([
                    'handle_factory' => new CurlFactory(self::MAX_CURL_HANDLES),
                    'select_timeout' => self::REQUEST_TIMEOUT,
                ])
            );
        } else {
            $handler = HandlerStack::create();
        }

        // Create the client and turn off Exception throwing.
        $client = new Client([
            // No exceptions of 404, 500 etc.
            'http_errors' => false,
            'handler' => $handler,
            // Curl options, any CURLOPT_* option is available
            'curl' => [
                // CURLOPT_BINARYTRANSFER => true,
            ],
            RequestOptions::CONNECT_TIMEOUT => self::REQUEST_TIMEOUT,
            // Allow redirects?
            // Set this to RequestOptions::ALLOW_REDIRECTS => false, to turn off.
            RequestOptions::ALLOW_REDIRECTS => [
                'max' => self::MAX_REDIRECTS,        // allow at most 10 redirects.
                'strict' => true,      // use "strict" RFC compliant redirects.
                'track_redirects' => false,
            ],
        ]);

        $requests = [];
        foreach ($urls as $key => $url) {
            if ($url) {
                $requests[$key] = new Request('GET', $url);
            }
        }

        $responses = collect([]);

        $pool = new Pool($client, $requests, [
            'concurrency' => self::GUZZLE_CONCURRENCY,
            'fulfilled' => function (\GuzzleHttp\Psr7\Response $response, $index) use ($responses) {
                $responses[$index] = new \Illuminate\Http\Client\Response($response);
            },
            'rejected' => function (mixed $reason, $index) use ($responses) {
                // $responses[$index] = new \Illuminate\Http\Client\Response($reason->getResponse());
                $responses[$index] = null;
            },
        ]);

        $pool->promise()->wait();

        return $responses;
    }

    /**
     * Get query URL from Response.
     */
    public static function getQueryFromResponse(Response $response): string
    {
        // @phpstan-ignore-next-line
        $uri = $response->transferStats->getRequest()->getUri();
        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        $path = $uri->getPath();
        $query = $uri->getQuery();

        return "{$scheme}://{$host}{$path}?{$query}";
    }
}
