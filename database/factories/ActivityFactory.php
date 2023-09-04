<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
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
            'description' => $this->faker->sentence(3),
            'image' => null,
            'user_id' => 1,
            'category_id' => null,
        ];
    }

    public function withImage(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'image' => 'activities/' . $this->faker->image('public/storage/activities', 10, 10, null, false),
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
