<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class BookTest extends TestCase
{
    public function testFirstPageAvailable()
    {
        $response = $this->get(route('api.books.index'));

        $response->assertStatus(200);
    }

    public function testHaveContent()
    {
        $response = $this->get(route('api.books.index'));
        $this->assertEquals(200, $response->getStatusCode());
        $json = json_decode($response->content());
        $this->assertNotEmpty($json->data, true);

        $response->assertStatus(200);
    }

    public function testAllPagesAvailable(string $route = null)
    {
        if (! $route) {
            $route = route('api.books.index');
        }
        $response = $this->get($route);
        $next = json_decode($response->content())->links->next;
        if ($next) {
            $response = $this->get($next);
            $response->assertStatus(200);

            return $this->testAllPagesAvailable($next);
        }
    }

    public function testRandomShow()
    {
        $response = $this->get(route('api.books.index'));
        $json = json_decode($response->content());
        $randomElement = array_rand($json->data, 1);
        $showLink = $json->data[$randomElement]->meta->show;
        $response = $this->get($showLink);

        $response->assertStatus(200);
    }

    public function testCount()
    {
        $response = $this->get(route('api.count', ['entity' => 'book']));

        $response->assertStatus(200);
    }
}
