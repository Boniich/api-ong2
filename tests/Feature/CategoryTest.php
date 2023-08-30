<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use RefreshDatabase;

    private string $url = 'api/v1/categories/';

    public function test_get_all_categories_successfully(): void
    {
        Category::factory()->create(['id' => 1]);

        $response = $this->getJson($this->url);

        $response->assertJson(['success' => true, 'data' => [['id' => 1]], 'message' => 'Categories retrived successfully']);
    }

    public function test_get_one_category_successfully(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        Category::factory()->create(['id' => 1]);

        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Category retrived successfully']);
    }

    public function test_unauthenticated_user_fails_to_show_a_category_by_id()
    {
        $response = $this->getJson($this->url . '1');
        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_not_found_category_to_show()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );
        $response = $this->getJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Category not found'])->assertStatus(404);
    }

    public function test_create_a_new_category_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->postJson($this->url, [
            'name' => 'new category',
            'description' => 'description of new category',
            'image' => UploadedFile::fake()->image('imageTest.png'),
        ]);

        destroyImagesInTests($response);

        $response->assertJson(['success' => true, 'data' => [
            'name' => 'new category',
            'description' => 'description of new category',
        ], 'message' => 'Category created successfully'])->assertStatus(201);
    }

    public function test_bad_request_at_create_a_category()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->postJson($this->url, [
            'name' => 'new category',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_unauthenticated_user_fails_to_create_a_category()
    {
        $response = $this->postJson($this->url, [
            'name' => 'new category',
            'description' => 'description of new category',
        ]);

        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_update_one_category_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        Category::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'name' => 'category actualizada',
            'description' => 'esta category fue actualizada'
        ]);

        $response->assertJson([
            'success' => true, 'data' => ['name' => 'category actualizada', 'description' => 'esta category fue actualizada'],
            'message' => 'Category updated successfully'
        ])->assertStatus(200);
    }

    public function test_not_found_category_to_update()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->putJson($this->url . '1', [
            'name' => 'category actualizada',
            'description' => 'esta category fue actualizada'
        ]);

        $response->assertJson(['success' => false, 'error' => 'Category not found'])->assertStatus(404);
    }

    public function test_bad_request_at_try_to_update_one_category()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        Category::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'image' => 'image.png',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_unauthenticated_user_fails_to_update_a_category()
    {
        Category::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'name' => 'new category',
            'description' => 'description of new category',
        ]);

        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_destroy_one_category_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        Category::factory()->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '1');
        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Category deleted successfully'])->assertStatus(200);
    }

    public function test_unauthenticated_user_fails_to_destroy_a_category()
    {
        Category::factory()->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_not_found_category_to_destroy()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['success' => false, 'error' => 'Category not found'])->assertStatus(404);
    }
}
