<?php

define('__API_AUTHORS__', '/api/authors');

it('first page available', function () {
    $response = $this->get(__API_AUTHORS__);
    $response->assertStatus(200);
});

it('have content', function () {
    $response = $this->get(__API_AUTHORS__);

    $this->assertEquals(200, $response->getStatusCode());
    $json = json_decode($response->content());
    $this->assertNotEmpty($json->data, true);

    $response->assertStatus(200);
});

it('all pages available', function () {
    $response = $this->get(__API_AUTHORS__.'?all=true');
    $response->assertStatus(200);
});

it('random author detail', function () {
    $response = $this->get(__API_AUTHORS__);
    $json = json_decode($response->content());
    $randomElement = array_rand($json->data, 1);
    $showLink = $json->data[$randomElement]->links->show;

    $response = $this->get($showLink);
    $response->assertStatus(200);
});

it('count', function () {
    $response = $this->get(__API_AUTHORS__.'/count');
    $response->assertStatus(200);
});
