<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Review;
use App\Models\Serie;
use App\Models\User;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement('SET foreign_key_checks=0');
        Review::truncate();
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
            $reviews = Review::factory()->count($faker->numberBetween(1, 5))->create();

            /** @var Review $review */
            foreach ($reviews as $review) {
                $exist_reviews_user_id = $entity->reviews->pluck('user_id');

                $user_id = User::inRandomOrder()->first()->id;
                if (! in_array($user_id, $exist_reviews_user_id->toArray())) {
                    $review->user_id = $user_id;

                    $dateTimes = [
                        $faker->dateTimeBetween('-1 week', '-5 day')->format('Y-m-d H:i:s'),
                        $review->created_at,
                    ];
                    $newDateTime = $faker->randomElements($dateTimes);
                    $date = $newDateTime[0];

                    $review->updated_at = $date;

                    try {
                        $entity->reviews()->save($review);
                        $entity->refresh();
                    } catch (\Throwable $th) {
                        // throw $th;
                    }
                } else {
                    Review::destroy($review->id);
                }
            }
        });
    }
}
