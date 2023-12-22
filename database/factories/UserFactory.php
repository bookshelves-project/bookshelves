<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Kiwilan\Steward\Enums\UserRoleEnum;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $gender = $this->faker->randomElements(GenderEnum::toArray())[0];
        // $pronouns_options = ['she', 'he', 'they'];
        // $pronouns = 'they';
        // if ('WOMAN' === $gender) {
        //     $pronouns = 'she';
        // } elseif ('MAN' === $gender) {
        //     $pronouns = 'he';
        // } else {
        //     $pronouns = $this->faker->randomElements($pronouns_options, $this->faker->numberBetween(1, 2));
        //     $pronouns = implode(', ', $pronouns);
        // }

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),

            // 'about' => $this->faker->text(),
            // 'use_gravatar' => false,
            // 'display_favorites' => $this->faker->boolean(),
            // 'display_reviews' => $this->faker->boolean(),
            // 'display_gender' => $this->faker->boolean(),
            'role' => UserRoleEnum::user->name,
            // 'gender' => $gender,
            // 'pronouns' => $pronouns,

            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function inactive(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'active' => false,
            ];
        });
    }

    public function superAdmin(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => UserRoleEnum::super_admin->value,
            ];
        });
    }

    public function admin(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => UserRoleEnum::admin->name,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }
}
