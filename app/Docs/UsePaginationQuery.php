<?php

namespace App\Docs\Strategies;

use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\RouteDocBlocker;
use Knuckles\Scribe\Extracting\Strategies\Strategy;

class UsePaginationQuery extends Strategy
{
    use ParamHelpers;

    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules): ?array
    {
        $methodDocBlock = RouteDocBlocker::getDocBlocksFromRoute($endpointData->route)['method'];
        $tags = $methodDocBlock->getTagsByName('usesPagination');

        if (empty($tags)) {
            // Doesn't use pagination
            return [];
        }

        return [
            'size' => [
                'description' => 'Number of entities to return in a page.',
                'type' => 'int',
                'required' => false,
                'example' => 5,
            ],
            'page' => [
                'description' => 'Page number to return, `1` by default',
                'type' => 'int',
                'required' => false,
                'example' => 1,
            ],
        ];
    }
}
