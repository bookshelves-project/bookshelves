<?php

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list api books page', function () {
    Book::factory(10)
        ->withRelations()
        ->hasAuthors(1)
        ->create()
    ;

    $response = $this->get(route('api.v1.books.index'));

    $response->assertStatus(200);
});

it('can show api book details', function () {
    Book::factory(5)
        ->hasAuthors(1)
        ->create()
    ;

    $book = Book::first();
    $response = $this->get(route('api.v1.books.show', [
        'author_slug' => $book->meta_author,
        'book_slug' => $book->slug,
    ]));

    $response->assertStatus(200);
});
