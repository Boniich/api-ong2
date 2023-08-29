<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'description' => $this->faker->sentence(3),
            'image' => null,
        ];
    }


    public function withImage(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'image' => 'categories/' . $this->faker->image('public/storage/categories', 300, 300, null, false)
            ];
        });
    }
}
