<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'ONG LARAVEL',
            'logo' => 'organization/' . $this->faker->image('public/storage/organization', 300, 300, null, false),
            'short_description'  => 'Somos una ONG que se dedica a enseñarle PHP y LARAVEL a los niños',
            'long_description' => 'ONG dedicada a la enseñanza',
            'welcome_text'  => 'Bienvenidos a la ONG LARAVEl',
            'address' => 'Calle Falsa 123',
            'phone'  => '123456',
            'cell_phone' => '123456',
            'facebook_url'  => 'facebook/ongLaravel',
            'linkedin_url' => 'linkedin/ongLaravel',
            'instagram_url'  => 'instagram/ongLaravel',
            'twitter_url' => 'twitter/ongLaravel'
        ];
    }
}
