<?php

it('can download random EPUB', function () {
    $response = $this->get('/api/books');
    $json = json_decode($response->content());
    $randomElement = array_rand($json->data, 1);
    $showLink = $json->data[$randomElement]->meta->show;
    // dump($showLink);
    $response = $this->get($showLink);
    $showContent = json_decode($response->content());
    $download_epub = $showContent->data->epub->download;
    $response = $this->get($download_epub);
    $contentType = $response->headers->get('Content-Type');
    $this->assertEquals($contentType, 'application/epub+zip');
});

it('can download random Series zip', function () {
    $response = $this->get('/api/series');
    $json = json_decode($response->content());
    $randomElement = array_rand($json->data, 1);
    $showLink = $json->data[$randomElement]->meta->show;

    $response = $this->get($showLink);
    $showContent = json_decode($response->content());
    $download_zip = $showContent->data->download;
    $response = $this->get($download_zip);
    $contentType = $response->headers->get('Content-Type');
    $this->assertEquals($contentType, 'application/octet-stream');
    $zip = File::glob(public_path('storage/*.zip'));
    foreach ($zip as $key => $file) {
        File::delete($file);
    }
});

it('can download random Authors zip', function () {
    $response = $this->get('/api/authors');
    $json = json_decode($response->content());
    $randomElement = array_rand($json->data, 1);
    $showLink = $json->data[$randomElement]->meta->show;

    $response = $this->get($showLink);
    $showContent = json_decode($response->content());
    $download_zip = $showContent->data->download;
    $response = $this->get($download_zip);
    $contentType = $response->headers->get('Content-Type');
    $this->assertEquals($contentType, 'application/octet-stream');
    $zip = File::glob(public_path('storage/*.zip'));
    foreach ($zip as $key => $file) {
        File::delete($file);
    }
});

it('can download all EPUB', function () {
    $response = $this->get(__API_BOOKS__.'?all=true');
    $responseContent = json_decode($response->content());
    $numberOfPages = $responseContent->data;
    for ($i = 0; $i < (sizeof($numberOfPages) - 1); $i++) {
        $showLink = $responseContent->data[$i]->meta->show;
        $response = $this->get($showLink);
        $showContent = json_decode($response->content());
        $download_epub = $showContent->data->epub->download;
        $this->assertNotNull($download_epub, 'Download EPUB link is not available for '.$responseContent->data[$i]->title);
    }
});
