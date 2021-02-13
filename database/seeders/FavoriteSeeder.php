<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $books = Book::inRandomOrder()->limit(10)->get();
        $authors = Author::inRandomOrder()->limit(5)->get();
        $series = Serie::inRandomOrder()->limit(5)->get();

        $books->each(function ($book, $key) use ($users, $books) {
            $user = $users->random();
            $book = $books->random();

            $book->favorites()->save($user);
        });

        $authors->each(function ($book, $key) use ($users, $authors) {
            $user = $users->random();
            $author = $authors->random();

            $author->favorites()->save($user);
        });

        $series->each(function ($book, $key) use ($users, $series) {
            $user = $users->random();
            $serie = $series->random();

            $serie->favorites()->save($user);
        });
    }
}
