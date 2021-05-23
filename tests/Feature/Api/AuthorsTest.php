<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthorTest extends TestCase
{
    public function test_first_page_available()
    {
        $response = $this->get(route('api.authors.index'));

        $response->assertStatus(200);
    }

    public function test_have_content()
    {
        $response = $this->get(route('api.authors.index'));
        $this->assertEquals(200, $response->getStatusCode());
        $json = json_decode($response->content());
        $this->assertNotEmpty($json->data, true);
    
        $response->assertStatus(200);
    }

    public function test_all_pages_available()
    {
        $response = $this->get(route('api.authors.index', ['limite' => 'full']));

        $response->assertStatus(200);
    }

    public function test_random_author_detail()
    {
        $response = $this->get(route('api.authors.index'));
        $json = json_decode($response->content());
        $randomElement = array_rand($json->data, 1);
        $showLink = $json->data[$randomElement]->meta->show;
        $response = $this->get($showLink);

        $response->assertStatus(200);
    }

    public function test_count()
    {
        $response = $this->get(route('api.count', ['entity' => 'author']));

        $response->assertStatus(200);
    }
}
