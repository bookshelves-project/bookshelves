<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Testing\TestResponse;

class SearchTest extends TestCase
{
    public function search(string $route, string $type): TestResponse
    {
        $response = $this->get($route);
        $this->assertEquals(200, $response->getStatusCode());
        $json = json_decode($response->content());
        $randomElement = array_rand($json->data, 1);

        $randomTitle = match ($type) {
            'title' => $json->data[$randomElement]->title,
            'name'  => $json->data[$randomElement]->name,
            default => 'unknown type',
        };

        $response = $this->get('/api/search?q=' . $randomTitle);

        if (200 !== $response->getStatusCode()) {
            echo $randomTitle;
        }

        return $response;
    }

    public function testRandomSearchSerieTitle()
    {
        $response = $this->search(route('api.v1.series.index', ['limit' => 'all']), 'title');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRandomSearchBookTitle()
    {
        $response = $this->search(route('api.v1.books.index', ['limit' => 'all']), 'title');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRandomSearchAuthorTitle()
    {
        $response = $this->search(route('api.v1.authors.index', ['limit' => 'all']), 'name');

        $this->assertEquals(200, $response->getStatusCode());
    }
}
