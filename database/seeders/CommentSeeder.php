<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use App\Models\Comment;
use DB;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET foreign_key_checks=0');
        Comment::truncate();
        DB::statement('SET foreign_key_checks=1');

        $books = Book::inRandomOrder()->limit(10)->get();
        $authors = Author::inRandomOrder()->limit(5)->get();
        $series = Serie::inRandomOrder()->limit(5)->get();

        $books->each(function ($book, $key) {
            $comment = Comment::factory()->create();

            $book->comments()->save($comment);
        });

        $series->each(function ($serie, $key) {
            $comment = Comment::factory()->create();

            $serie->comments()->save($comment);
        });

        $authors->each(function ($author, $key) {
            $comment = Comment::factory()->create();

            $author->comments()->save($comment);
        });
    }
}
