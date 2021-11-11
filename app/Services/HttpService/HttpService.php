<?php

namespace App\Services\HttpService;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class HttpService
{
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
            $chunk = array_chunk($url_list, config('http.pool_limit'), true);

            /**
             * async query on each chunk.
             *
             * @var array $limited_url_list
             */
            foreach ($chunk as $limited_url_list) {
                $responses = self::executePool($limited_url_list);
                foreach ($responses as $key => $response) {
                    $responses_list[$key] = $response;
                }
            }
        } else {
            foreach ($url_list as $id => $url) {
                $responses_list[$id] = Http::get($url);
            }
        }

        return $responses_list;
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

    /**
     * Get responses from array of URL.
     *
     * @return Response[]
     */
    private static function executePool(array $url_list): array
    {
        /**
         * remove value without url and set it to Collection.
         */
        $url_list = array_filter($url_list, fn ($value) => ! is_null($value) && '' !== $value);
        $url_list = collect($url_list);

        /**
         * Prepare pool on each value, so each url.
         */
        $pool = function (\Illuminate\Http\Client\Pool $pool) use ($url_list) {
            $array_pools = [];
            foreach ($url_list as $id => $url) {
                if ($url) {
                    $arrayPools[] = $pool->as($id)->get($url);
                }
            }

            return $array_pools;
        };

        $responses_to_keep = [];

        try {
            /**
             * Execute pool.
             */
            $responses = \Illuminate\Support\Facades\Http::pool($pool);

            /**
             * Filter responses to remove errors.
             */
            foreach ($responses as $key => $response) {
                if ($response instanceof Response) {
                    $responses_to_keep[$key] = $response;
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $responses_to_keep;
    }
}
