<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
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
            'slug' => $this->faker->sentence(3),
            'content' => $this->faker->sentence(3),
            'image' => null,
            'user_id' => 1,
            'category_id' => null
        ];
    }

    public function withImage(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'image' => 'news/' . $this->faker->image('public/storage/news', 300, 300, null, false),
            ];
        });
    }

    public function addCategory(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'category_id' => 1
            ];
        });
    }
}
