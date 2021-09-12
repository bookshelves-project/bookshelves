<?php

namespace Tests\Feature\Api;

use File;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;

class DownloadTest extends TestCase
{
    public function download(string $route, string $type): TestResponse
    {
        $response = $this->get($route);
        $json = json_decode($response->content());
        $randomElement = array_rand($json->data, 1);
        $showLink = $json->data[$randomElement]->meta->show;

        $response = $this->get($showLink);
        $showContent = json_decode($response->content());

        $download = match ($type) {
            'epub'  => $showContent->data->epub->download,
            'zip'   => $showContent->data->download,
            default => 'unknown type',
        };

        $response = $this->get($download);

        return $response;
    }

    public function testCanDownloadRandomEpub()
    {
        $response = $this->download(route('api.books.index'), 'epub');

        $contentType = $response->headers->get('Content-Type');
        $this->assertEquals($contentType, 'application/epub+zip');
    }

    public function testCanDownloadRandomSerieZip()
    {
        $response = $this->download(route('api.series.index'), 'zip');

        $contentType = $response->headers->get('Content-Type');
        $this->assertEquals($contentType, 'application/octet-stream');
        $zip = File::glob(public_path('storage/*.zip'));
        foreach ($zip as $key => $file) {
            File::delete($file);
        }
    }

    public function testCanDownloadRandomAuthorZip()
    {
        $response = $this->download(route('api.authors.index', ['limit' => 'all']), 'zip');

        $contentType = $response->headers->get('Content-Type');
        $this->assertEquals($contentType, 'application/octet-stream');
        $zip = File::glob(public_path('storage/*.zip'));
        foreach ($zip as $key => $file) {
            File::delete($file);
        }
    }

    public function testCanDownloadAllEpub()
    {
        $response = $this->get(route('api.books.index', ['limit' => 'all']));
        $responseContent = json_decode($response->content());
        $numberOfPages = $responseContent->data;

        for ($i = 0; $i < (sizeof($numberOfPages) - 1); $i++) {
            $showLink = $responseContent->data[$i]->meta->show;
            $response = $this->get($showLink);
            $showContent = json_decode($response->content());
            $download_epub = $showContent->data->epub->download;
            $this->assertNotNull($download_epub, 'Download EPUB link is not available for ' . $responseContent->data[$i]->title);
        }
    }
}
