<?php

namespace App\Utils;

use Illuminate\Http\Client\Response;

class HttpTools
{
    public const LIMIT = 250;

    /**
     * Get responses from array of URL.
     *
     * @return Response[]
     */
    public static function async(array $urlList, int $limit = 350): array
    {
        $responses = [];

        try {
            // if $urlList exceed $limit, chunk array
            if (sizeof($urlList) > $limit) {
                $chunk = array_chunk($urlList, $limit);
                $responses_list = [];
                // async on each chunk
                foreach ($chunk as $key => $list) {
                    $responses = self::asyncQuery($urlList);
                    array_push($responses_list, $responses);
                }
                // transform multidimensional array to array
                $responses_list = array_column($responses_list, 'value', 'key');
                $responses = $responses_list;
            } else {
                $responses = self::asyncQuery($urlList);
            }
        } catch (\Throwable $th) {
            BookshelvesTools::console(__METHOD__, $th);
        }

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

    /**
     * Get responses from array of URL.
     *
     * @return Response[]
     */
    private static function asyncQuery(array $urlList): array
    {
        $urlList = array_filter($urlList, fn ($value) => ! is_null($value) && '' !== $value);
        $urlList = collect($urlList);
        $pool = function (\Illuminate\Http\Client\Pool $pool) use ($urlList) {
            $arrayPools = [];
            foreach ($urlList as $id => $url) {
                if ($url) {
                    $arrayPools[] = $pool->as($id)->get($url);
                }
            }

            return $arrayPools;
        };
        $responses = \Illuminate\Support\Facades\Http::pool($pool);
        $responses_keep = [];
        foreach ($responses as $key => $response) {
            if ($response instanceof Response) {
                $responses_keep[$key] = $response;
            }
        }

        return $responses_keep;
    }
}
