<?php

namespace Tests\Feature\Catalog;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;

class CatalogTest extends TestCase
{
    public function testStatus()
    {
        $response = $this->get(route('catalog.index'));
        $response->assertStatus(200);

        $response = $this->get(route('catalog.series'));
        $response->assertStatus(200);

        $response = $this->get(route('catalog.authors'));
        $response->assertStatus(200);
    }

    public function testSearch()
    {
        $book = Book::first();

        $response = $this->get(route('catalog.search', [
            'q' => $book->title,
        ]));
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $book = Book::first();
        $author = Author::first();
        $serie = Serie::first();

        $response = $this->get(route('catalog.books.show', [
            'author' => $author->slug,
            'book'   => $book->slug,
        ]));
        $response->assertStatus(200);

        $response = $this->get(route('catalog.series.show', [
            'author' => $author->slug,
            'serie'  => $serie->slug,
        ]));
        $response->assertStatus(200);

        $response = $this->get(route('catalog.authors.show', [
            'author' => $author->slug,
        ]));
        $response->assertStatus(200);
    }
}
