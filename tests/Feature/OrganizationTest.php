<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrganizationTest extends TestCase
{

    use RefreshDatabase;

    private string $url = 'api/v1/organization';

    public function test_retrived_organization_data_successfully(): void
    {
        Organization::factory(1)->create(['id' => 1]);

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson($this->url);

        destroyImagesInTestsForArrayWithIndex($response, 'logo');

        $response->assertJson(['success' => true, 'data' => [[
            'name' => 'ONG LARAVEL',
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
        ]], 'message' => 'Organization retrived successfully'])->assertStatus(200);
    }

    public function test_update_organization_data_successfully(): void
    {
        Organization::factory(1)->create(['id' => 1]);
        $response = $this->putJson($this->url, [
            'name' => 'Actualizando',
            'short_description'  => 'Actualizando',
            'long_description' => 'Actualizando',
            'welcome_text'  => 'Actualizando',
            'address' => 'Actualizando',
            'phone'  => 'Actualizando',
            'cell_phone' => 'Actualizando',
            'facebook_url'  => 'Actualizando',
            'linkedin_url' => 'Actualizando',
            'instagram_url'  => 'Actualizando',
            'twitter_url' => 'Actualizando'
        ]);

        destroyImagesInTests($response, 'logo');

        $response->assertJson(['success' => true, 'data' => [
            'name' => 'Actualizando',
            'short_description'  => 'Actualizando',
            'long_description' => 'Actualizando',
            'welcome_text'  => 'Actualizando',
            'address' => 'Actualizando',
            'phone'  => 'Actualizando',
            'cell_phone' => 'Actualizando',
            'facebook_url'  => 'Actualizando',
            'linkedin_url' => 'Actualizando',
            'instagram_url'  => 'Actualizando',
            'twitter_url' => 'Actualizando'
        ], 'message' => 'Organization data updated successfully'])->assertStatus(200);
    }
}
