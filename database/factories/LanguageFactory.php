<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $language = $this->faker->languageCode();
        $is_exist = Language::whereSlug($language)->first();
        if (! $is_exist) {
            return [
                'name' => $language,
                'slug' => $language,
            ];
        }
    }
}
