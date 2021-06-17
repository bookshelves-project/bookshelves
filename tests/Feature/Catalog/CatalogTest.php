<?php

namespace Tests\Feature\Catalog;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Tests\TestCase;

class CatalogTest extends TestCase
{
	public function testStatus()
	{
		$response = $this->get(route('api.catalog.index'));
		$response->assertStatus(200);

		$response = $this->get(route('api.catalog.series'));
		$response->assertStatus(200);

		$response = $this->get(route('api.catalog.authors'));
		$response->assertStatus(200);
	}

	public function testSearch()
	{
		$book = Book::first();

		$response = $this->get(route('api.catalog.search', [
			'q' => $book->title,
		]));
		$response->assertStatus(200);
	}

	public function testShow()
	{
		$book = Book::first();
		$author = Author::first();
		$serie = Serie::first();

		$response = $this->get(route('api.catalog.books.show', [
			'author' => $author->slug,
			'book' => $book->slug,
		]));
		$response->assertStatus(200);

		$response = $this->get(route('api.catalog.series.show', [
			'author' => $author->slug,
			'serie' => $serie->slug,
		]));
		$response->assertStatus(200);

		$response = $this->get(route('api.catalog.authors.show', [
			'author' => $author->slug,
		]));
		$response->assertStatus(200);
	}
}
