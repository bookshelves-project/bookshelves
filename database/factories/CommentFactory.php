<?php

namespace Database\Factories;

use DateTime;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        $users = User::all();
        $user = $users->random();

        $random_datetime = [
            new DateTime(),
            $faker->dateTimeBetween('-1 week', '-3 day'),
            $faker->dateTimeBetween('-3 week', '-1 week'),
            $faker->dateTimeBetween('-6 month', '-1 month'),
            $faker->dateTimeBetween('-2 year', '-1 year'),
            $faker->dateTimeBetween('-8 year', '-5 year'),
            $faker->dateTime
        ];
        $datetime = $faker->randomElements($random_datetime);

        return [
            'text'       => $faker->paragraph(),
            'rating'     => $faker->numberBetween(null, 5),
            'user_id'    => $user->id,
            'created_at' => $datetime[0],
        ];
    }
}
