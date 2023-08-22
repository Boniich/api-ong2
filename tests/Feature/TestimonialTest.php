<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TestimonialTest extends TestCase
{

    use RefreshDatabase;

    private string $url = 'api/v1/testimonials/';

    public function test_retrived_all_testimonials_successfully(): void
    {
        Testimonial::factory(1)->create(['id' => 1]);
        $response = $this->getJson($this->url);

        $response->assertJson(['success' => true, 'data' => [['id' => 1]], 'message' => 'Testimonials retrived successfully']);
    }

    public function test_retrived_one_testimonial_successfully(): void
    {
        Testimonial::factory(1)->create(['id' => 1]);
        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Testimonial retrived successfully']);
    }

    public function test_not_found_testimonial_to_show(): void
    {
        $response = $this->getJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Testimonial not found']);
    }

    public function test_create_a_new_testimonial_successfully(): void
    {
        $response = $this->postJson($this->url, [
            'id' => 1,
            'name' => 'Juan Carlos',
            'image' => UploadedFile::fake()->image('imageTest.png'),
            'description' => 'Esta ong esta muy buena',
        ]);

        destroyImagesInTests($response);

        $response->assertJson(['success' => true, 'data' => [
            'id' => 1,
            'name' => 'Juan Carlos',
            'description' => 'Esta ong esta muy buena',
        ], 'message' => 'Testimonial created successfully'])->assertStatus(201);
    }

    public function test_update_testimonial_successfully(): void
    {

        Testimonial::factory(1)->withImage()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'name' => 'Juan Carlos',
            'image' => UploadedFile::fake()->image('imageTest.png'),
            'description' => 'Esta ong esta muy buena',
        ]);

        destroyImagesInTests($response);

        $response->assertJson(['success' => true, 'data' => [
            'id' => 1,
            'name' => 'Juan Carlos',
            'description' => 'Esta ong esta muy buena',
        ], 'message' => 'Testimonial updated successfully'])->assertStatus(200);
    }

    public function test_not_found_testimonial_to_update(): void
    {
        $response = $this->putJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Testimonial not found']);
    }

    public function test_destroy_testimonial_successfully(): void
    {
        Testimonial::factory(1)->create(['id' => 1]);
        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Testimonial deleted successfully']);
    }

    public function test_not_found_testimonial_to_destroy(): void
    {
        $response = $this->deleteJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Testimonial not found']);
    }
}
