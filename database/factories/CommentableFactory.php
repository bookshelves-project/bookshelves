<?php

namespace Database\Factories;

use DateTime;
use App\Models\User;
use App\Models\Commentable;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Commentable::class;

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
            $faker->dateTimeBetween('-1 week', '-3 day', 'Europe/Paris'),
            $faker->dateTimeBetween('-3 week', '-1 week', 'Europe/Paris'),
            $faker->dateTimeBetween('-6 month', '-1 month', 'Europe/Paris'),
            $faker->dateTimeBetween('-2 year', '-1 year', 'Europe/Paris'),
            $faker->dateTimeBetween('-8 year', '-5 year', 'Europe/Paris'),
            $faker->dateTime
        ];
        $datetime = $faker->randomElements($random_datetime);

        $text = [
            $faker->paragraph($faker->numberBetween(2, 10), true),
            $faker->paragraph($faker->numberBetween(2, 10), true)
        ];
        $text = implode('<br>', $text);
        $text = explode(' ', $text);
        foreach ($text as $key => $word) {
            if (! strpos($word, '.')) {
                if ($key % 8 === 0) {
                    $text[$key] = "*$word*";
                }
                if ($key % 9 === 0) {
                    $text[$key] = "**$word**";
                }
            }
        }
        $date = $datetime[0]->format('Y-m-d H:i:s');

        return [
            'text'       => implode(' ', $text),
            'rating'     => $faker->numberBetween(null, 5),
            'created_at' => $date,
        ];
    }
}
