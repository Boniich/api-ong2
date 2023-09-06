<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    private string $url = 'api/v1/users/';

    public function test_get_all_user_successfully(): void
    {
        User::factory(1)->create(['id' => 1]);
        $response = $this->getJson($this->url);

        $response->assertJson(['success' => true, 'data' => [['id' => 1]], 'message' => 'Users retrived successfully'])->assertStatus(200);
    }

    public function test_get_one_user_by_id_successfully(): void
    {
        User::factory(1)->create(['id' => 1]);
        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'User retrived successfully'])->assertStatus(200);
    }

    public function test_not_found_user_to_show_successfully(): void
    {
        $response = $this->getJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'User not found'])->assertStatus(404);
    }

    public function test_create_a_new_user_successfully(): void
    {
        $this->seed(RoleSeeder::class);

        $response = $this->postJson($this->url, [
            'name' => 'Carlos Tests',
            'email' => 'test@gmail.com',
            'password' => '123456',
            'address' => 'Calle false 123',
            'profile_image' => UploadedFile::fake()->image('imageTest.png'),
        ]);

        destroyImagesInTests($response, 'profile_image');

        $response->assertJson(['success' => true, 'data' => [
            'name' => 'Carlos Tests',
            'email' => 'test@gmail.com',
            'address' => 'Calle false 123',
        ], 'message' => 'User created successfully'])->assertStatus(201);
    }

    public function test_update_user_successfully()
    {
        User::factory(1)->create(['id' => 1]); //agregar imagen con el estado

        $response = $this->putJson($this->url . '1', [
            'name' => 'Carlos Tests Actu',
            'email' => 'testactu@gmail.com',
            'password' => '123456',
            'address' => 'Calle false 123',
            'profile_image' => UploadedFile::fake()->image('imageTest.png'),
        ]);

        destroyImagesInTests($response, 'profile_image');

        $response->assertJson(['success' => true, 'data' => [
            'id' => 1,
            'name' => 'Carlos Tests Actu',
            'email' => 'testactu@gmail.com',
            'address' => 'Calle false 123',
        ], 'message' => 'User updated successfully'])->assertStatus(200);
    }

    public function test_not_found_user_to_update_successfully(): void
    {
        $response = $this->putJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'User not found'])->assertStatus(404);
    }

    public function test_destroy_one_user_successfully(): void
    {
        User::factory(1)->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '1');
        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'User deleted successfully'])->assertStatus(200);
    }

    public function test_not_found_user_to_destroy_successfully(): void
    {
        $response = $this->deleteJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'User not found'])->assertStatus(404);
    }
}
