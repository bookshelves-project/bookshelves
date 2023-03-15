<?php

namespace Database\Factories;

use App\Enums\PostCategoryEnum;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Kiwilan\Steward\Enums\PublishStatusEnum;
use Kiwilan\Steward\Filament\Config\FilamentBuilder\Modules\WordpressBuilder;
use Kiwilan\Steward\Services\FactoryService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $factory = FactoryService::make('posts');
        $timestamps = $factory->dateTime()->timestamps();
        $created_at = $timestamps->getCreatedAt();
        $update_at = $timestamps->getUpdatedAt();
        $published_at = $timestamps->getCreatedAt();

        return [
            'title' => ucfirst($this->faker->words(5, true)),
            'summary' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(PublishStatusEnum::toValues()),
            'is_pinned' => $this->faker->boolean(15),
            'category' => $this->faker->randomElement(PostCategoryEnum::toValues()),
            // 'picture' => $factory->media->single(),
            // 'content' => $factory->builder(WordpressBuilder::class),
            'created_at' => $created_at,
            'updated_at' => $update_at,
            'published_at' => $published_at,
        ];
    }

    public function author(): PostFactory
    {
        return $this->state(function (array $attributes) {
            $users = User::whereIn('role', [
                UserRole::super_admin,
                UserRole::admin,
                UserRole::editor,
            ])->get();
            $author = $users->random(1)->first();

            return [
                'author_id' => $author->id,
            ];
        });
    }
}
