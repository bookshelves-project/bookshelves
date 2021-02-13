<?php

namespace Database\Factories;

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

        return [
            'text'           => $faker->paragraph(),
            'rating'         => $faker->numberBetween(null, 5),
            'user_id'        => $user->id,
        ];
    }
}
