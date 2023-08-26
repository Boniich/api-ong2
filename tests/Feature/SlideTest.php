<?php

namespace Tests\Feature;

use App\Models\Slide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SlideTest extends TestCase
{

    use RefreshDatabase;

    private string $url = 'api/v1/slides/';

    public function test_get_all_slides_successfully(): void
    {
        User::factory()->create(['id' => 1]);
        $slide = Slide::factory()->create(['id' => 1]);

        $image = $slide->image;

        destroyImage($image);

        $response = $this->getJson($this->url);

        $response->assertJson(['success' => true, 'data' => [['id' => 1]], 'message' => 'Slides retrived successfully'])->assertStatus(200);
    }

    public function test_get_one_slide_successfully(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1])
        );

        $slide = Slide::factory()->create(['id' => 1]);

        $image = $slide->image;

        destroyImage($image);

        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Slide retrived successfully'])->assertStatus(200);
    }

    public function test_unauthenticated_user_fails_to_show_a_slide_by_id()
    {
        $response = $this->getJson($this->url . '1');
        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_not_found_slide_to_show()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1])
        );

        $response = $this->getJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Slide not found']);
    }

    public function test_create_a_new_slide_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1])
        );

        $response = $this->postJson($this->url, [
            'name' => 'Slide in test',
            'description' => 'description of slide test',
            'image' => UploadedFile::fake()->image('imageTest.png'),
        ]);

        destroyImagesInTests($response);

        $response->assertJson(['success' => true, 'data' => [
            'name' => 'Slide in test',
            'description' => 'description of slide test',
        ], 'message' => 'Slide created successfully'])->assertStatus(201);
    }

    public function test_bad_request_at_create_a_slide()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1])
        );

        $response = $this->postJson($this->url, [
            'name' => 'Slide in test',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_unauthenticated_user_fails_to_create_a_slide()
    {
        $response = $this->postJson($this->url, [
            'name' => 'Slide in test',
            'description' => 'description of slide test',
        ]);

        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_update_one_slide_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1])
        );

        $slide = Slide::factory()->create(['id' => 1]);

        $image = $slide->image;
        destroyImage($image);

        $response = $this->putJson($this->url . '1', [
            'name' => 'Actualizando',
            'description' => 'Actualizando',
        ]);

        $response->assertJson(['success' => true, 'data' => [
            'name' => 'Actualizando',
            'description' => 'Actualizando',
        ], 'message' => 'Slide updated successfully'])->assertStatus(200);
    }

    public function test_bad_request_at_try_to_update_one_slide()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1])
        );

        $slide = Slide::factory()->create(['id' => 1]);

        $image = $slide->image;
        destroyImage($image);

        $response = $this->putJson($this->url . '1', [
            'image' => 'image.png',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_unauthenticated_user_fails_to_update_a_slide()
    {
        User::factory()->create(['id' => 1]);
        $slide = Slide::factory()->create(['id' => 1]);

        $image = $slide->image;
        destroyImage($image);

        $response = $this->putJson($this->url . '1', [
            'name' => 'Actualizando',
            'description' => 'Actualizando',
        ]);

        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_not_found_slide_to_update()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1])
        );

        $response = $this->putJson($this->url . '1', [
            'name' => 'Actualizando',
            'description' => 'Actualizando',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Slide not found']);
    }

    public function test_destroy_a_slide_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1])
        );

        Slide::factory()->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '1');
        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Slide deleted successfully']);
    }

    public function test_unauthenticated_user_fails_to_destroy_a_slide()
    {
        User::factory()->create(['id' => 1]);
        $slide = Slide::factory()->create(['id' => 1]);

        $image = $slide->image;
        destroyImage($image);

        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_not_found_slide_to_destroy()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1])
        );

        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['success' => false, 'error' => 'Slide not found']);
    }
}
