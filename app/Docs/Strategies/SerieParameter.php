<?php

namespace App\Docs\Strategies;

use App\Models\Serie;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\Strategies\Strategy;

class SerieParameter extends Strategy
{
    use ParamHelpers;

    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules): ?array
    {
        $urlParams = [];
        if ('api.series.show' === $endpointData->route->getName()) {
            $serie = Serie::inRandomOrder()->first();

            $urlParams = [
                'author' => [
                    'description' => "`slug` of author, case of multiple author choose `meta_author` like `{$serie->meta_author}`",
                    'required' => true,
                    'example' => $serie->meta_author,
                ],
                'serie' => [
                    'description' => "`slug` of serie like `{$serie->slug}`",
                    'required' => true,
                    'example' => $serie->slug,
                ],
            ];
        }

        return $urlParams;
    }
}
