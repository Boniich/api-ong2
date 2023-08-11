<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->sentence(3),
            'image' => 'projects/' . $this->faker->image('public/storage/projects', 300, 300, null, false),
            'due_date' => $this->faker->date()
        ];
    }
}
