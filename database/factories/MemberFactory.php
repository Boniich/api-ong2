<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(3),
            'description' => $this->faker->sentence(3),
            'image' => null,
            'facebook_url'  => $this->faker->sentence(3),
            'linkedin_url' => $this->faker->sentence(3)
        ];
    }

    public function withImage(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'image' => 'members/' . $this->faker->image('public/storage/members', 300, 300, null, false)
            ];
        });
    }
}
