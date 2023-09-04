<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentTest extends TestCase
{

    use RefreshDatabase;

    private string $url = 'api/v1/comments/';

    public function test_get_all_comments_successfully(): void
    {
        User::factory()->create(['id' => 1]);
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->getJson($this->url);

        $response->assertJson(['success' => true, 'data' => [['id' => 1]], 'message' => 'Comments retrived successfully'])->assertStatus(200);
    }


    public function test_get_one_comment_successfully(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );


        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Comment retrived successfully'])->assertStatus(200);
    }

    public function test_not_found_response_at_try_to_show_a_comment()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->getJson($this->url . '10');

        $response->assertJson(['success' => false, 'error' => 'Comment not found'])->assertStatus(404);
    }

    public function test_unauthenticated_user_fails_to_show_a_comment_by_id()
    {
        User::factory()->create(['id' => 1]);
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->getJson($this->url . '1');
        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_create_a_comment_in_data_base_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);

        $this->postJson($this->url, [
            'text' => 'text of comment',
            'news_id' => 1,
        ]);

        $this->assertDatabaseHas('comments', [
            'text' => 'text of comment',
            'news_id' => 1,
        ]);
    }

    public function test_response_at_create_a_comment_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);

        $response = $this->postJson($this->url, [
            'text' => 'text of comment',
            'news_id' => 1,
        ]);

        $response->assertJson(['success' => true, 'data' => [
            'text' => 'text of comment',
            'news_id' => 1,
        ], 'message' => 'Comment created successfully'])->assertStatus(201);
    }

    public function test_bad_request_response_at_try_to_create_a_comment()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);

        $response = $this->postJson($this->url, [
            "news_id" => 1,
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_not_found_news_id_response_at_try_to_create_a_comment()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        $response = $this->postJson($this->url, [
            "text" => 'text of comment',
            "news_id" => 1,
        ]);

        $response->assertJson(['success' => false, 'error' => 'News ID not found'])->assertStatus(404);
    }

    public function test_unauthenticated_user_fails_to_create_a_comment()
    {

        User::factory()->create(['id' => 1]);
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->postJson($this->url, [
            'text' => 'text of comment',
            'news_id' => 1,
        ]);
        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_update_a_comment_in_data_base_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $this->putJson($this->url . '1', [
            'text' => 'text of comment',
            'active' => false,
            'news_id' => 1,
        ]);

        $this->assertDatabaseHas('comments', [
            'id' => 1,
            'text' => 'text of comment',
            'active' => false,
            'news_id' => 1,
        ]);
    }

    public function test_response_at_update_one_comment_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'text' => 'text of comment',
            'active' => false,
            'news_id' => 1,
        ]);

        $response->assertJson(['success' => true, 'data' => [
            'id' => 1,
            'text' => 'text of comment',
            'active' => false,
            'news_id' => 1,
        ], 'message' => 'Comment updated successfully'])->assertStatus(200);
    }

    public function test_bad_request_response_at_try_to_update_a_comment()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'text' => 'text of comment',
            'active' => "false",
            'news_id' => 1,
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_not_found_comment_response_to_update()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '10', [
            'text' => 'text of comment',
            'active' => false,
            'news_id' => 1,
        ]);

        $response->assertJson(['success' => false, 'error' => 'Comment not found'])->assertStatus(404);
    }

    public function test_not_found_news_id_at_try_to_update_a_comment()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'text' => 'text of comment',
            'active' => false,
            'news_id' => 15,
        ]);

        $response->assertJson(['success' => false, 'error' => 'News ID not found'])->assertStatus(404);
    }

    public function test_unauthenticated_user_fails_to_update_a_news()
    {

        User::factory()->create(['id' => 1]);
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'text' => 'text of comment',
            'active' => false,
            'news_id' => 1
        ]);
        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_destroy_a_comment_in_data_base_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);
        $comment = Comment::factory()->create(['id' => 1]);

        $this->deleteJson($this->url . '1');

        $this->assertModelMissing($comment);
    }

    public function test_successfully_response_at_destroy_one_comment()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Comment deleted successfully'])->assertStatus(200);
    }

    public function test_not_found_comment_response_at_try_to_destroy_one_comment()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '10');

        $response->assertJson(['success' => false, 'error' => 'Comment not found'])->assertStatus(404);
    }

    public function test_unauthenticated_user_fails_to_destroy_a_comment()
    {
        User::factory()->create(['id' => 1]);
        News::factory()->create(['id' => 1]);
        Comment::factory()->create(['id' => 1]);
        $response = $this->deleteJson($this->url . '1');
        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }
}
