<?php

namespace App\Docs\Strategies;

use App\Models\Book;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\Strategies\Strategy;

class BookParameter extends Strategy
{
    use ParamHelpers;

    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules): ?array
    {
        $urlParams = [];
        if ('api.books.show' === $endpointData->route->getName()) {
            $book = Book::inRandomOrder()->first();

            $urlParams = [
                'author' => [
                    'description' => "`slug` of author, case of multiple author choose `meta_author` like `{$book->meta_author}`",
                    'required' => true,
                    'example' => $book->meta_author,
                ],
                'book' => [
                    'description' => "`slug` of book like `{$book->slug}`",
                    'required' => true,
                    'example' => $book->slug,
                ],
            ];
        }

        return $urlParams;
    }
}
