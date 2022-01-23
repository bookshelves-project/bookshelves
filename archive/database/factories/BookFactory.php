<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        $title = ucfirst($faker->words($faker->numberBetween(2, 5), true));

        return [
            'title' => $title,
            'title_sort' => Str::slug($title),
            'slug' => Str::slug($title),
            'contributor' => 'Book factory',
            'description' => $faker->paragraph(),
            'date' => $faker->dateTime(),
            'rights' => 'Bookshelves',
            'volume' => $faker->numberBetween(0, 8),
        ];
    }
}
