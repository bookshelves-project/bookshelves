<?php

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;

class BookTest extends TestCase
{
    use WithFaker;

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
