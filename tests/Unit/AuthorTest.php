<?php

use Tests\TestCase;
use App\Models\Author;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthorTest extends TestCase
{
    use WithFaker;
    // use DatabaseMigrations;

    public function testAuthorCanBeCreate()
    {
        // Given
        $author = Author::factory()->create();
        $author->save();

        // When
        $author_to_find = Author::find($author->id);

        // Then
        $this->assertNotNull($author_to_find);
        Author::destroy($author->id);
    }
}
