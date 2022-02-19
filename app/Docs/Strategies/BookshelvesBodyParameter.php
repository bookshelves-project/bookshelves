<?php

namespace App\Docs\Strategies;

use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\Strategies\Strategy;

class BookshelvesBodyParameter extends Strategy
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
            'submission.send' => 'submission',
        ];

        foreach ($routes as $name => $method) {
            if ("api.v1.{$name}" === $this->routeName) {
                $this->urlParams = $this->{$method}();
            }
        }
    }

    private function submission(): array
    {
        // dump('submission');

        return [
            // 'name' => 'Name',
            // 'email' => 'user@email.com',
            // 'honeypot' => false,
            // 'message' => 'Hello! This is a message for you!',
        ];
    }
}
