<?php

define('__API_SERIES__', '/api/series');

it('first page available', function () {
    $response = $this->get(__API_SERIES__);

    $response->assertStatus(200);
});

it('have content', function () {
    $response = $this->get(__API_SERIES__);

    $this->assertEquals(200, $response->getStatusCode());
    $json = json_decode($response->content());
    $this->assertNotEmpty($json->data, true);

    $response->assertStatus(200);
});

it('all pages available', function () {
    $response = $this->get(__API_SERIES__.'?limit=full');
    $response->assertStatus(200);
});

it('random serie detail', function () {
    $response = $this->get(__API_SERIES__);
    $json = json_decode($response->content());
    $randomElement = array_rand($json->data, 1);
    $showLink = $json->data[$randomElement]->meta->show;

    $response = $this->get($showLink);
    $response->assertStatus(200);
});

it('count', function () {
    $response = $this->get('/api/count?entity=serie');
    $response->assertStatus(200);
});
