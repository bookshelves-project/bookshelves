<?php

namespace Database\Seeders;

use DB;
use DateTime;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

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
        
        $limit = 3;
        $books_count = intval(Book::count() / $limit);
        $series_count = intval(Serie::count() / $limit);
        $authors_count = intval(Author::count() / $limit);
        $books = Book::inRandomOrder()->limit($books_count)->get();
        $authors = Author::inRandomOrder()->limit($authors_count)->get();
        $series = Serie::inRandomOrder()->limit($series_count)->get();

        self::generate($books);
        self::generate($series);
        self::generate($authors);
    }
    
    public static function generate(Collection $collect)
    {
        $faker = \Faker\Factory::create();
        $collect->each(function ($entity, $key) use ($faker) {
            $comments = Comment::factory()->count($faker->numberBetween(1, 5))->create();

            foreach ($comments as $comment) {
                $entity->comments()->save($comment);
            }
            // remove duplicates
            $users_id = [];
            foreach ($entity->comments as $key => $comment) {
                if (in_array($comment->user_id, $users_id)) {
                    Comment::destroy($comment->id);
                } else {
                    $dateTimes = [
                        $faker->dateTime(new DateTime('+1 week')),
                        $comment->created_at
                    ];
                    $newDateTime = $faker->randomElements($dateTimes);

                    $comment->updated_at = $newDateTime[0];
                    $comment->save(['timestamps' => false]);
                }
                array_push($users_id, $comment->user_id);
            }
        });
    }
}
