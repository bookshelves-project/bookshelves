<?php

namespace Database\Factories;

use App\Enums\BookTypeEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
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
            'slug_sort' => Str::slug($title),
            'slug' => Str::slug($title),
            'contributor' => 'contributor',
            'description' => $faker->paragraph(),
            'released_on' => $faker->dateTime(),
            'rights' => $faker->words(5, true),
            'volume' => $faker->numberBetween(0, 8),
            'page_count' => $faker->randomDigit(),
            'maturity_rating' => null,
            'disabled' => false,
            'type' => BookTypeEnum::novel(),
            'isbn10' => $faker->isbn10(),
            'isbn13' => $faker->isbn13(),
            'identifiers' => [
                'isbn10' => $faker->isbn10(),
                'isbn13' => $faker->isbn13(),
            ],
        ];
    }

    public function withRelations()
    {
        return $this->state(function (array $attributes) {
            $authors = Author::factory(2)
                ->create()
            ;
            $serie = Serie::factory()
                ->create()
            ;
            $language = Language::factory()
                ->create()
            ;
            $publisher = Publisher::factory()
                ->create()
            ;

            return [
                // 'serie_id' => $serie->id,
                'serie_id' => $serie->id,
                'language_slug' => $language->slug,
                'publisher_id' => $publisher->id,
            ];
        });
    }
}
