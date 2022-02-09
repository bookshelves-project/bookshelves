<?php

namespace App\Docs\Strategies;

use App\Models\Author;
use App\Models\Book;
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
            'search.index' => $this->search(),
        ];

        foreach ($routes as $name => $method) {
            if ("api.v1.{$name}" === $this->routeName) {
                $this->urlParams = $method;
            }
        }
    }

    private function search(): array
    {
        $faker = \Faker\Factory::create();
        $entity = '';
        if ($faker->boolean(25)) {
            $entity = Author::inRandomOrder()->first();
            $entity = $entity->lastname;
        } else {
            $entity = Book::inRandomOrder()->first();
            $entity = $entity->title;
        }
        $entity = strtolower($entity);

        return [
            'q' => [
                'description' => "`slug` of serie in `meta.slug` languages' list, example: `{$entity}`",
                'required' => true,
                'example' => $entity,
            ],
        ];
    }
}
