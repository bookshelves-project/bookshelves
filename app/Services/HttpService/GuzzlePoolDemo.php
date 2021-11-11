<?php

/*
 *   Guzzle Examples
 *   Copyleft (Ɔ) 2017  https://blog.rewiv.com sikofitt <eric@rewiv.com>
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   See <http://www.gnu.org/licenses/>.
 *
 */

namespace App\Services\HttpService;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlFactory;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;

class GuzzlePoolDemo
{
    public function create()
    {
        define('MAX_CURL_HANDLES', 100);
        define('MAX_REDIRECTS', 10);
        define('REQUEST_TIMEOUT', 30);
        define('OUTPUT_DIR', __DIR__.'/images');
        define('GUZZLE_CONCURRENCY', 5);

        if (false === file_exists(OUTPUT_DIR)) {
            mkdir(OUTPUT_DIR);
        }

        $urls = [
            'http://placehold.it/350x153.png',
            'http://placehold.it/450x251.png',
            'http://placehold.it/659x257.png',
        ];

        if (extension_loaded('curl')) {
            $handler = HandlerStack::create(
                new CurlMultiHandler([
                    'handle_factory' => new CurlFactory(MAX_CURL_HANDLES),
                    'select_timeout' => REQUEST_TIMEOUT,
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
                CURLOPT_BINARYTRANSFER => true,
            ],
            RequestOptions::CONNECT_TIMEOUT => REQUEST_TIMEOUT,
            // Allow redirects?
            // Set this to RequestOptions::ALLOW_REDIRECTS => false, to turn off.
            RequestOptions::ALLOW_REDIRECTS => [
                'max' => MAX_REDIRECTS,        // allow at most 10 redirects.
                'strict' => true,      // use "strict" RFC compliant redirects.
                'track_redirects' => false,
            ],
        ]);

        $generator = function (array $urls) {
            foreach ($urls as $url) {
                $request = new Request('GET', $url);

                yield $request;
            }
        };

        $responses_list = [];

        $pool = new Pool(
            $client,
            $generator($urls),
            [
                'concurrency' => GUZZLE_CONCURRENCY,
                'fulfilled' => function (Response $response) use ($responses_list) {
                    // Get the last part of the url as the filename.
                    $image = $response->getBody()->getContents();

                    // However you want to name the files..
                    // Just an example.
                    $imageTypes = sprintf('/(%s)/i', implode('|', ['gif', 'png', 'jpeg', 'jpg', 'tiff']));

                    preg_match($imageTypes, $image, $matches);

                    $fileName = true === isset($matches[0]) ?
                            sprintf('%s.%s', md5(microtime(true)), strtolower($matches[0])) :
                            sprintf('%s.tmp', md5(microtime(true)));

                    // file_put_contents(OUTPUT_DIR.'/'.$fileName, $image);

                    $responses_list[$fileName] = $image;
                    dump($fileName);

                    return $responses_list;
                },
                'rejected' => function (Response $response) {
                    fwrite(STDOUT, sprintf('Failed getting data, code was %d.', $response->getStatusCode()));
                },
            ]
        );

        $promise = $pool->promise();
        $promise_full = $promise->wait();

        dump($promise);
        dump($promise->then(fn ($data) => $data));
        dump($promise_full);
        dump($responses_list);

        return $responses_list;
    }
}
