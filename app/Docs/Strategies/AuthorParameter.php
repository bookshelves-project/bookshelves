<?php

namespace App\Docs\Strategies;

use App\Models\Author;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\Strategies\Strategy;

class AuthorParameter extends Strategy
{
    use ParamHelpers;

    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules): ?array
    {
        $urlParams = [];
        if ('api.authors.show' === $endpointData->route->getName()) {
            $author = Author::inRandomOrder()->first();

            $urlParams = [
                'author' => [
                    'description' => "`slug` of author like `{$author->slug}`",
                    'required' => true,
                    'example' => $author->slug,
                ],
            ];
        }

        return $urlParams;
    }
}
