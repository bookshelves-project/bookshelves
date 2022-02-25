<?php

namespace Database\Factories;

use App\Enums\AuthorRoleEnum;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $firstname = $faker->firstName();
        $lastname = $faker->lastName();
        $name = $lastname.' '.$firstname;

        return [
            'lastname' => $lastname,
            'firstname' => $firstname,
            'name' => $name,
            'slug' => Str::slug($name),
            'role' => AuthorRoleEnum::aut(),
            'description' => $faker->paragraph(),
            'link' => $faker->url(),
            'note' => $faker->paragraph(),
        ];
    }
}
