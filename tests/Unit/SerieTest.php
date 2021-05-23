<?php

use Tests\TestCase;
use App\Models\Serie;
use Illuminate\Foundation\Testing\WithFaker;

class SerieTest extends TestCase
{
    use WithFaker;

    public function testSerieCanBeCreate()
    {
        // Given
        $book = Serie::factory()->create();
        $book->save();

        // When
        $book_to_find = Serie::find($book->id);

        // Then
        $this->assertNotNull($book_to_find);
        // Serie::destroy($book->id);
    }
}
