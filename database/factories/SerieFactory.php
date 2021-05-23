<?php

namespace Database\Factories;

use App\Models\Serie;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class SerieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Serie::class;

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
            'title'      => $title,
            'title_sort' => MetadataExtractorTools::getSortString($title),
            'slug'       => Str::slug($title),
        ];
    }
}
