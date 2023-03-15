<?php

namespace App\Docs\Strategies;

use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\RouteDocBlocker;
use Knuckles\Scribe\Extracting\Strategies\Strategy;

class UsePaginationQuery extends Strategy
{
    /**
     * Trait containing some helper methods for dealing with "parameters",
     * such as generating examples and casting values to types.
     * Useful if your strategy extracts information about parameters or generates examples.
     */
    use ParamHelpers;

    /**
     * @see https://scribe.knuckles.wtf/laravel/advanced/plugins
     *
     * @param  ExtractedEndpointData  $endpointData The endpoint we are currently processing.
     *                                            Contains details about httpMethods, controller, method, route, url, etc, as well as already extracted data.
     * @param  array  $routeRules   Array of rules for the ruleset which this route belongs to.
     *
     * See the documentation linked above for more details about writing custom strategies.
     */
    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules = []): ?array
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
