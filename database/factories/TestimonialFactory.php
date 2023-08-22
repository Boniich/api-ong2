<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'image' => null,
            'description' => $this->faker->sentence(3),
        ];
    }

    public function withImage(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'image' => 'testimonials/' . $this->faker->image('public/storage/testimonials', 300, 300, null, false),
            ];
        });
    }
}
