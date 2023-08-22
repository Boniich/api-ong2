<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialMediaItem>
 */
class SocialMediaItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'image' => null,
            'url' => $this->faker->sentence(3),
        ];
    }

    public function withImage(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'image' => 'socialMediaItems/' . $this->faker->image('public/storage/socialMediaItems', 300, 300, null, false),
            ];
        });
    }
}
