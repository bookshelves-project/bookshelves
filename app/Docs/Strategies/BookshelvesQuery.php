<?php

namespace App\Docs\Strategies;

use App\Models\Author;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\Strategies\Strategy;

class BookshelvesQuery extends Strategy
{
    use ParamHelpers;

    public function __construct(
        public mixed $routeName,
        public ?array $urlParams = []
    ) {
    }

    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules): ?array
    {
        $this->routeName = $endpointData->route->getName();

        $this->routes();

        return $this->urlParams;
    }

    private function routes()
    {
        $routes = [
            'entities.search' => 'search',
        ];

        foreach ($routes as $name => $method) {
            if ("api.{$name}" === $this->routeName) {
                $this->urlParams = $this->{$method}();
            }
        }
    }

    private function search(): array
    {
        $entity = Author::inRandomOrder()->firstOrFail();
        $entity = strtolower($entity->lastname);

        return [
            'q' => [
                'description' => "`slug` of serie in `meta.slug` languages' list, example: `{$entity}`",
                'required' => true,
                'example' => $entity,
            ],
        ];
    }
}
