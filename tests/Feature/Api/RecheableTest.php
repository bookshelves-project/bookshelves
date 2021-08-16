<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class RecheableTest extends TestCase
{
    protected $books = 'api.books.index';
    protected $authors = 'api.authors.index';
    protected $series = 'api.series.index';

    /**
     * Define all entities to test
     */
    protected function getRoutes()
    {
        return [
            'book'   => $this->books,
            'author' => $this->authors,
            'serie'  => $this->series
        ];
    }

    /**
     * Parse $route and next routes from pagination
     */
    protected function getAllPages(string $route, string $next = null)
    {
        if ($next !== null) {
            $route = $next;
        } else {
            $route = route($route);
        }
        $response = $this->get($route);
        $next = json_decode($response->content())->links->next;
        if ($next) {
            $response = $this->get($next);
            $response->assertStatus(200);

            return $this->getAllPages($route, $next);
        }
        $response->assertStatus(200);
    }

    /**
     * Test all pages of API for each route into getRoutes()
     */
    public function testMainPages()
    {
        foreach ($this->getRoutes() as $key => $route) {
            $this->getAllPages($route);
        }
    }

    /**
     * Test if each entity of getRoutes() have content
     */
    public function testHaveContent()
    {
        foreach ($this->getRoutes() as $key => $route) {
            $response = $this->get(route($route));
            $this->assertEquals(200, $response->getStatusCode());
            $json = json_decode($response->content());
            $this->assertNotEmpty($json->data, true);

            $response->assertStatus(200);
        }
    }

    /**
     * Test random entity with show link from getRoutes()
     */
    public function testRandomShow()
    {
        foreach ($this->getRoutes() as $key => $route) {
            $response = $this->get(route($route));
            $json = json_decode($response->content());
            $randomElement = array_rand($json->data, 1);
            $showLink = $json->data[$randomElement]->meta->show;
            $response = $this->get($showLink);
    
            $response->assertStatus(200);
        }
    }

    /**
     * Count entities from getRoutes()
     */
    public function testCount()
    {
        foreach ($this->getRoutes() as $key => $route) {
            $response = $this->get(route('api.count', ['entity' => $key]));

            $response->assertStatus(200);
        }
    }
}
