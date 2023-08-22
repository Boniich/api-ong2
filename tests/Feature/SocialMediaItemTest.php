<?php

namespace Tests\Feature;

use App\Models\SocialMediaItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SocialMediaItemTest extends TestCase
{
    use RefreshDatabase;

    private string $url = 'api/v1/socialmediaitems/';

    public function test_get_all_social_media_item_successfully(): void
    {
        SocialMediaItem::factory(1)->create(['id' => 1]);

        $response = $this->getJson($this->url);

        $response->assertJson(['success' => true, 'data' => [['id' => 1]], 'message' => 'Social Media Items retrived successfully'])->assertStatus(200);
    }

    public function test_get_one_social_media_item_successfully(): void
    {

        SocialMediaItem::factory(1)->create(['id' => 1]);

        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Social Media Item retrived successfully'])->assertStatus(200);
    }

    public function test_not_found_social_media_item_to_show(): void
    {
        $response = $this->getJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Social Media Item not found'])->assertStatus(404);
    }

    public function test_create_a_social_media_item_successfully(): void
    {

        $response = $this->postJson($this->url, [
            'id' => 1,
            'name' => 'Facebook',
            'image' => UploadedFile::fake()->image('imageTest.png'),
            'url' => 'facebook/ong'
        ]);

        destroyImagesInTests($response);

        $response->assertJson(['success' => true, 'data' => [
            'id' => 1,
            'name' => 'Facebook',
            'url' => 'facebook/ong'
        ], 'message' => 'Social Media Item created successfully'])->assertStatus(201);
    }

    public function test_update_a_social_media_item_successfully(): void
    {
        SocialMediaItem::factory(1)->withImage()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'name' => 'instagram',
            'image' => UploadedFile::fake()->image('imageTest.png'),
            'url' => 'instagram/ong'
        ]);

        destroyImagesInTests($response);

        $response->assertJson(['success' => true, 'data' => [
            'name' => 'instagram',
            'url' => 'instagram/ong',
        ], 'message' => 'Social Media Item updated successfully'])->assertStatus(200);
    }

    public function test_not_found_social_media_item_to_update(): void
    {
        $response = $this->putJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Social Media Item not found'])->assertStatus(404);
    }

    public function test_destroy_a_social_media_item_successfully(): void
    {
        SocialMediaItem::factory(1)->withImage()->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Social Media Item deleted successfully']);
    }

    public function test_not_found_social_media_item_to_destroy(): void
    {
        $response = $this->putJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Social Media Item not found'])->assertStatus(404);
    }
}
