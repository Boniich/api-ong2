<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NewsTest extends TestCase
{

    use RefreshDatabase;

    private string $url = 'api/v1/news/';

    public function test_get_all_news_successfully(): void
    {

        User::factory()->create(['id' => 1]);
        News::factory()->create(['id' => 1]);


        $response = $this->getJson($this->url);

        $response->assertJson(['success' => true, 'data' => [['id' => 1]], 'message' => 'News retrived successfully'])->assertStatus(200);
    }


    public function test_get_one_news_successfully(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        News::factory()->create(['id' => 1]);
        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'News retrived successfully'])->assertStatus(200);
    }

    public function test_not_found_response_at_show_one_news()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => false, 'error' => 'News not found'])->assertStatus(404);
    }

    public function test_unauthenticated_user_fails_to_show_a_news_by_id()
    {
        User::factory()->create(['id' => 1]);
        News::factory()->create(['id' => 1]);

        $response = $this->getJson($this->url . '1');
        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_create_a_news_in_data_base_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        $this->postJson($this->url, [
            'name' => 'news created',
            'slug' => 'slug created',
            'content' => 'content created',
        ]);

        $this->assertDatabaseHas('news', [
            'name' => 'news created',
            'slug' => 'slug created',
            'content' => 'content created',
        ]);
    }

    public function test_response_at_create_a_news_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        $response = $this->postJson($this->url, [
            'name' => 'news created',
            'slug' => 'slug created',
            'content' => 'content created',
        ]);

        $response->assertJson(['success' => true, 'data' => [
            'name' => 'news created',
            'slug' => 'slug created',
            'content' => 'content created',
        ], 'message' => 'News created successfully'])->assertStatus(201);
    }

    public function test_bad_request_response_at_create_a_news()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        $response = $this->postJson($this->url, [
            'name' => 'news created',
            'slug' => 'slug created',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_not_found_category_id_response_at_try_to_create_a_news()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        $response = $this->postJson($this->url, [
            'name' => 'news created',
            'slug' => 'slug created',
            'content' => 'content created',
            'category_id' => 10,
        ]);

        $response->assertJson(['success' => false, 'error' => 'Category ID not found'])->assertStatus(404);
    }

    public function test_unauthenticated_user_fails_to_create_a_news_by_id()
    {

        User::factory()->create(['id' => 1]);
        News::factory()->create(['id' => 1]);

        $response = $this->postJson($this->url, [
            'name' => 'news created',
            'content' => 'content created',
        ]);

        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_update_a_news_in_data_base_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        News::factory()->create(['id' => 1]);

        $this->putJson($this->url . '1', [
            'name' => 'news updated',
            'slug' => 'slug updated',
            'content' => 'content updated',
        ]);

        $this->assertDatabaseHas('news', [
            'name' => 'news updated',
            'slug' => 'slug updated',
            'content' => 'content updated',
        ]);
    }

    public function test_response_at_update_a_news_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        News::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'name' => 'news updated',
            'slug' => 'slug updated',
            'content' => 'content updated',
        ]);

        $response->assertJson(['success' => true, 'data' => [
            'name' => 'news updated',
            'slug' => 'slug updated',
            'content' => 'content updated'
        ], 'message' => 'News updated successfully'])->assertStatus(200);
    }

    public function test_bad_request_response_at_try_to_update_news()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        News::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'name' => 'news updated',
            'slug' => 'slug updated',
            'content' => 'content updated',
            'image' => 'image.png',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_not_found_news_response_at_try_to_update()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        News::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '5', [
            'name' => 'news updated',
            'slug' => 'slug updated',
            'content' => 'content updated',
        ]);

        $response->assertJson(['success' => false, 'error' => 'News not found'])->assertStatus(404);
    }


    public function test_not_found_category_id_response_at_try_to_update()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        News::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'name' => 'news updated',
            'slug' => 'slug updated',
            'content' => 'content updated',
            'category_id' => 15
        ]);

        $response->assertJson(['success' => false, 'error' => 'Category ID not found'])->assertStatus(404);
    }

    public function test_unauthenticated_user_fails_to_update_a_news()
    {

        User::factory()->create(['id' => 1]);
        News::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'name' => 'news updated',
            'slug' => 'slug updated',
            'content' => 'content updated',
        ]);
        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }


    public function test_destroy_a_news_in_data_base_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        $news = News::factory()->create(['id' => 1]);

        $this->deleteJson($this->url . '1');

        $this->assertModelMissing($news);
    }

    public function test_response_at_destroy_a_news_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        News::factory()->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'News deleted successfully'])->assertStatus(200);
    }

    public function test_not_found_response_at_destroy_a_news()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        News::factory()->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '45');

        $response->assertJson(['success' => false, 'error' => 'News not found'])->assertStatus(404);
    }

    public function test_unauthenticated_user_fails_to_destroy_a_news()
    {
        User::factory()->create(['id' => 1]);
        News::factory()->create(['id' => 1]);
        $response = $this->deleteJson($this->url . '1');
        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }
}
