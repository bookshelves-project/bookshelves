<?php

namespace App\Docs\Strategies;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\Strategies\Strategy;
use ReflectionClass;
use Str;

class ApplicationParameter extends Strategy
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
     * @param  ExtractedEndpointData  $endpointData The endpoint we are currently processing.
     *                                            Contains details about httpMethods, controller, method, route, url, etc, as well as already extracted data.
     * @param  array  $routeRules   Array of rules for the ruleset which this route belongs to.
     *
     * See the documentation linked above for more details about writing custom strategies.
     */
    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules = []): ?array
    {
        $this->routeName = $endpointData->route->getName();
        $this->routes();

        return $this->urlParams;
    }

    private function routes()
    {
        $routes = [
            'book' => [
                'class' => Book::class,
                'routes' => ['books.show'],
                'field' => 'id',
            ],
            'author' => [
                'class' => Author::class,
                'routes' => ['authors.show', 'authors.show.books', 'authors.show.series'],
                'field' => 'id',
            ],
            'serie' => [
                'class' => Serie::class,
                'routes' => ['series.show', 'series.show.books', 'series.show.series'],
                'field' => 'id',
            ],
        ];

        foreach ($routes as $name => $model) {
            $class = $model['class'];
            $routes = $model['routes'];
            $field = $model['field'];

            foreach ($routes as $route) {
                if ("api.{$route}" === $this->routeName) {
                    $this->urlParams = $this->setParameter($class, $field);
                }
            }
        }
    }

    private function setParameter(string $model, string $field)
    {
        $random_entity = $model::inRandomOrder()->first();

        $instance = new $model();
        $class = new ReflectionClass($instance);
        $name = Str::lower($class->getShortName());

        return [
            "{$name}_{$field}" => [
                'description' => "`{$field}` of {$name} in `meta.{$name}` {$name}s' list, example: `{$random_entity->{$field}}`",
                'required' => true,
                'example' => $random_entity->{$field},
            ],
        ];
    }
}
