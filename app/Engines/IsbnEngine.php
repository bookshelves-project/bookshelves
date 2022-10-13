<?php

namespace App\Engines;

use Kiwilan\Steward\Services\HttpService;

/**
 * @property string[] $api_list
 */
class IsbnEngine
{
    public function __construct(
        public string $isbn,
        public array $api_list = [],
    ) {
    }

    public static function make(string $isbn): self
    {
        $engine = new IsbnEngine($isbn);

        // 0596156715
        $isbn = '9782266266284';
        $engine->api_list = [
            'worldcat' => "http://classify.oclc.org/classify2/Classify?isbn={$isbn}&summary=true", // https://www.worldcat.org
            'openlibrary' => "http://openlibrary.org/api/volumes/brief/isbn/{$isbn}.json", // https://openlibrary.org
            'google_book' => "https://www.googleapis.com/books/v1/volumes?q=isbn:{$isbn}", // https://developers.google.com/books/docs/v1/using
        ];

        $responses = HttpService::make($engine->api_list)
            ->execute()
        ;

        foreach ($responses as $origin => $response) {
            dump($response);
        }

        return $engine;
    }
}
