<?php

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookTest extends TestCase
{
    use WithFaker;
    // use DatabaseMigrations;
    // use DatabaseTransactions;

    public function testBookCanBeCreate()
    {
        // Given
        $book = Book::factory()->create();
        $book->save();

        // When
        $book_to_find = Book::find($book->id);

        // Then
        $this->assertNotNull($book_to_find);
        Book::destroy($book->id);
    }
}
