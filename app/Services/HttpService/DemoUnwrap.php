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

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlFactory;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;
use function GuzzleHttp\Promise\unwrap;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;

require __DIR__.'/vendor/autoload.php';

define('MAX_CURL_HANDLES', 100);
define('MAX_REDIRECTS', 10);
define('REQUEST_TIMEOUT', 30);
/**
 * Go through $urls and create the guzzle promises.
 *
 * @param array $urls
 *                    Array of urls to try and retrieve
 *
 * @return array
 *               An array of Response objects
 */
function createPromises(array $urls)
{
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

    $promises = [];
    foreach ($urls as $key => $url) {
        $promises[$key] = $client->getAsync((string) $url);
    }

    return $promises;
}

$urls = [
    'http://placehold.it/350x153.png',
    'http://placehold.it/450x251.png',
    'http://placehold.it/659x257.png',
];

if (false === file_exists('images')) {
    mkdir('images');
}

$promises = createPromises($urls);
$results = unwrap($promises);

/**
 * @var int      $key
 * @var Response $response
 */
foreach ($results as $key => $response) {
    $data = [];
    // Make sure we have something
    if (in_array($response->getStatusCode(), [200, 201], true)) {
        // Get the last part of the url as the filename.
        $urlArray = explode('/', $urls[$key]);
        // Extract the filename
        $fileName = end($urlArray);
        // Write the contents of the image to a file.
        file_put_contents(__DIR__.'/images/'.$fileName, $response->getBody()->getContents());
    } else {
        fwrite(STDOUT, sprintf('Failed getting data for %s.  Code was %d.', $urls[$key], $response->getStatusCode()));
    }
}
