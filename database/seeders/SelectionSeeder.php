<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SelectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET foreign_key_checks=0');
        DB::table('selectionables')->truncate();
        DB::statement('SET foreign_key_checks=1');

        $users = User::all();
        $books = Book::inRandomOrder()->limit(5)->get();
        // $authors = Author::inRandomOrder()->limit(5)->get();
        $series = Serie::inRandomOrder()->limit(5)->get();

        $books->each(function ($book, $key) use ($users) {
            $user = $users->first();

            $book->selections()->save($user);
        });

        // $authors->each(function ($author, $key) use ($users) {
        //     $user = $users->first();

        //     $author->selections()->save($user);
        // });

        $series->each(function ($serie, $key) use ($users) {
            $user = $users->first();

            $serie->selections()->save($user);
        });
    }
}
