<?php

namespace App\Docs\Strategies;

use Mpociot\Reflection\DocBlock;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\RouteDocBlocker;
use Knuckles\Scribe\Extracting\Strategies\Strategy;
use Knuckles\Camel\Extraction\ExtractedEndpointData;

class BookshelvesMetadata extends Strategy
{
    use ParamHelpers;

    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules): ?array
    {
        $route = $endpointData->route->getName();

        /** @var DocBlock $methodDocBlock */
        $methodDocBlock = RouteDocBlocker::getDocBlocksFromRoute($endpointData->route)['method'];
        $origin = $methodDocBlock->getLongDescription()->getContents();

        return [
            'description' => $origin."\n\nRoute name: `{$route}`",
        ];
    }
}
