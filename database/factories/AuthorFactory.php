<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        $firstname = $faker->firstName;
        $lastname = $faker->lastName;
        $name = $firstname . ' ' . $lastname;

        return [
            'lastname'  => $lastname,
            'firstname' => $firstname,
            'name'      => $name,
            'slug'      => Str::slug($name),
        ];
    }
}
