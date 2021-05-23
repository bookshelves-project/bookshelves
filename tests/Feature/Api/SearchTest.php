<?php

it('random search serie title', function () {
    $response = $this->get(__API_SERIES__ . '?all=true');

    $this->assertEquals(200, $response->getStatusCode());
    $json = json_decode($response->content());
    $randomElement = array_rand($json->data, 1);
    $randomTitle = $json->data[$randomElement]->title;
    $response = $this->get('/api/search?q=' . $randomTitle);
    if ($response->getStatusCode() !== 200) {
        echo $randomTitle;
    }
    $this->assertEquals(200, $response->getStatusCode());
});

it('random search book title', function () {
    $response = $this->get(__API_BOOKS__ . '?all=true');

    $this->assertEquals(200, $response->getStatusCode());
    $json = json_decode($response->content());
    $randomElement = array_rand($json->data, 1);
    $randomTitle = $json->data[$randomElement]->title;
    $response = $this->get('/api/search?q=' . $randomTitle);
    if ($response->getStatusCode() !== 200) {
        echo $randomTitle;
    }
    $this->assertEquals(200, $response->getStatusCode());
});

it('random search author title', function () {
    $response = $this->get(__API_AUTHORS__ . '?all=true');

    $this->assertEquals(200, $response->getStatusCode());
    $json = json_decode($response->content());
    $randomElement = array_rand($json->data, 1);
    $randomTitle = $json->data[$randomElement]->name;
    $response = $this->get('/api/search?q=' . $randomTitle);
    if ($response->getStatusCode() !== 200) {
        echo $randomTitle;
    }
    $this->assertEquals(200, $response->getStatusCode());
});
