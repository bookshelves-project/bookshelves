<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class SerieTest extends TestCase
{
    public function testFirstPageAvailable()
    {
        $response = $this->get(route('api.series.index'));

        $response->assertStatus(200);
    }

    public function testHaveContent()
    {
        $response = $this->get(route('api.series.index'));
        $this->assertEquals(200, $response->getStatusCode());
        $json = json_decode($response->content());
        $this->assertNotEmpty($json->data, true);

        $response->assertStatus(200);
    }

    public function testAllPagesAvailable()
    {
        $response = $this->get(route('api.series.index', ['limit' => 'all']));

        $response->assertStatus(200);
    }

    public function testRandomAuthorDetail()
    {
        $response = $this->get(route('api.series.index'));
        $json = json_decode($response->content());
        $randomElement = array_rand($json->data, 1);
        $showLink = $json->data[$randomElement]->meta->show;
        $response = $this->get($showLink);

        $response->assertStatus(200);
    }

    public function testCount()
    {
        $response = $this->get(route('api.count', ['entity' => 'serie']));

        $response->assertStatus(200);
    }
}
