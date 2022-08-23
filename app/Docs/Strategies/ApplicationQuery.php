<?php

namespace App\Docs\Strategies;

use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\Strategies\Strategy;

class ApplicationQuery extends Strategy
{
    /**
     * Trait containing some helper methods for dealing with "parameters",
     * such as generating examples and casting values to types.
     * Useful if your strategy extracts information about parameters or generates examples.
     */
    use ParamHelpers;

    public function __construct(
        public mixed $routeName,
        public ?array $urlParams = []
    ) {
    }

    /**
     * @see https://scribe.knuckles.wtf/laravel/advanced/plugins
     *
     * @param ExtractedEndpointData $endpointData The endpoint we are currently processing.
     *                                            Contains details about httpMethods, controller, method, route, url, etc, as well as already extracted data.
     * @param array                 $routeRules   Array of rules for the ruleset which this route belongs to.
     *
     * See the documentation linked above for more details about writing custom strategies.
     */
    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules): ?array
    {
        $this->routeName = $endpointData->route->getName();

        $this->routes();

        return $this->urlParams;
    }

    private function routes()
    {
        $routes = [
            'search' => 'search',
        ];

        foreach ($routes as $name => $method) {
            if ("api.{$name}" === $this->routeName) {
                $this->urlParams = $this->{$method}();
            }
        }
    }

    private function search(): array
    {
        // $entity = Author::inRandomOrder()->firstOrFail();
        // $entity = strtolower($entity->lastname);

        return [
            'q' => [
                // 'description' => "`slug` of serie in `meta.slug` languages' list, example: `{$entity}`",
                'required' => true,
                // 'example' => $entity,
            ],
        ];
    }
}
