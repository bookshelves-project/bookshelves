<?php

namespace Database\Seeders;

use DB;
use App\Models\Book;
use App\Models\User;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET foreign_key_checks=0');
        DB::table('favoritables')->truncate();
        DB::statement('SET foreign_key_checks=1');

        $users = User::all();
        
        $limit = 2;
        $books_count = intval(Book::count() / $limit);
        $series_count = intval(Serie::count() / $limit);
        $authors_count = intval(Author::count() / $limit);
        $books = Book::inRandomOrder()->limit($books_count)->get();
        $authors = Author::inRandomOrder()->limit($authors_count)->get();
        $series = Serie::inRandomOrder()->limit($series_count)->get();

        self::generate($books, $users);
        self::generate($series, $users);
        self::generate($authors, $users);
    }

    public static function generate(Collection $collect, Collection $users)
    {
        $faker = \Faker\Factory::create();
        $collect->each(function ($entity, $key) use ($faker, $users) {
            $user = $users->random();

            $entity->favorites()->save($user, ['created_at' => $faker->dateTime]);
        });
    }
}
