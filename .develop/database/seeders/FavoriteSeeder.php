<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use App\Models\User;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class FavoritableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
            $date = $faker->dateTimeBetween('-3 week', '-1 week', 'Europe/Paris')->format('Y-m-d H:i:s');

            $entity->favorites()->save($user, ['created_at' => $date]);
        });
    }
}
