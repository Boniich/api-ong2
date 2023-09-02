<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ActivityTest extends TestCase
{

    use RefreshDatabase;

    private string $url = 'api/v1/activities/';

    public function test_get_all_activities(): void
    {
        User::factory()->create(['id' => 1]);
        Activity::factory()->create(['name' => 'actividad de test']);

        $response = $this->getJson($this->url);

        $response->assertJson(['success' => true, 'data' => [['name' => 'actividad de test']], 'message' => 'Activities retrived successfully'])->assertStatus(200);
    }

    public function test_get_one_activity(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        Activity::factory()->create(['id' => 1, 'name' => 'actividad de test']);

        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['name' => 'actividad de test'], 'message' => 'Activity retrived successfully'])->assertStatus(200);
    }

    public function test_not_found_activity_to_show()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        Activity::factory()->create(['id' => 1, 'name' => 'actividad de test']);

        $response = $this->getJson($this->url . '3');

        $response->assertJson(['success' => false, 'error' => 'Activity not found']);
    }

    public function test_unauthenticated_user_fails_to_show_a_activity_by_id()
    {
        $response = $this->getJson($this->url . '1');
        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_create_a_new_activity_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        $response = $this->postJson($this->url, [
            'name' => 'new activity',
            'slug' => 'slug of activity',
            'description' => 'description of new activity',
        ]);

        $response->assertJson(['success' => true, 'data' => [
            'name' => 'new activity',
            'slug' => 'slug of activity',
            'description' => 'description of new activity'
        ], 'message' => 'Activity created successfully'])->assertStatus(201);
    }

    public function test_bad_request_at_try_to_create_a_new_activity()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        $response = $this->postJson($this->url, [
            'slug' => 'slug of activity',
            'description' => 'description of new activity',
        ]);


        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_unauthenticated_user_fails_to_create_a_activity()
    {
        $response = $this->postJson($this->url, [
            'name' => 'test activity',
            'slug' => 'slug of activity',
            'description' => 'description of new activity',
        ]);

        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_not_found_category_id_to_add_at_create_an_activity()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        $response = $this->postJson($this->url, [
            'name' => 'test activity',
            'slug' => 'slug of activity',
            'description' => 'description of new activity',
            'category_id' => 10,
        ]);

        $response->assertJson(['success' => false, 'error' => 'Category ID not found'])->assertStatus(404);
    }

    public function test_update_one_activity_successfully()
    {

        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        Activity::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'name' => 'Actualizando',
            'slug' => 'Actualizando',
            'description' => 'Actualizando',
        ]);
        $response->assertJson(['success' => true, 'data' => ['name' => 'Actualizando'], 'message' => 'Activity updated successfully'])->assertStatus(200);
    }

    public function test_bad_request_at_try_to_update_one_activity()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        Activity::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'image' => 'image.png'
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_unauthenticated_user_fails_to_update_a_activity()
    {

        User::factory()->create(['id' => 1]);
        Activity::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'name' => 'test activity',
            'slug' => 'slug of activity',
            'description' => 'description of new activity',
        ]);

        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_not_found_activity_to_update()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        Activity::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '10', [
            'name' => 'test activity',
            'slug' => 'slug of activity',
            'description' => 'description of new activity',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Activity not found'])->assertStatus(404);
    }

    public function test_not_found_category_to_update_one_activity()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        Activity::factory()->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'name' => 'test activity',
            'slug' => 'slug of activity',
            'description' => 'description of new activity',
            'category_id' => 10
        ]);

        $response->assertJson(['success' => false, 'error' => 'Category ID not found'])->assertStatus(404);
    }

    public function test_destroy_one_activity_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        Activity::factory()->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Activity deleted successfully'])->assertStatus(200);
    }

    public function test_unauthenticated_user_fails_to_destroy_an_activity()
    {
        User::factory()->create(['id' => 1]);
        Activity::factory()->create(['id' => 1]);
        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['status_code' => 401, 'success' => false, 'message' => 'Unauthenticated'])->assertStatus(401);
    }

    public function test_not_found_activity_to_destroy()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        Activity::factory()->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '10');

        $response->assertJson(['success' => false, 'error' => 'Activity not found'])->assertStatus(404);
    }

    //el registro realmente sea creado en la base de datos

    public function test_create_an_activity_model_successfully()
    {

        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        $this->postJson($this->url, [
            'name' => 'activity created',
            'slug' => 'slug of activity',
            'description' => 'description of new activity',
        ]);

        $this->assertDatabaseHas('activities', ['name' => 'activity created']);
    }

    //el registro realmente sea actualizado de la base de datos


    public function test_update_an_activity_model_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        Activity::factory()->create(['id' => 1]);

        $this->putJson($this->url . '1', [
            'name' => 'activity updated',
            'description' => 'description of new activity',
        ]);

        $this->assertDatabaseHas('activities', ['name' => 'activity updated']);
    }

    //el registro realmente se elimine de la base datos


    public function test_destroy_an_activity_model_successfully()
    {
        Sanctum::actingAs(
            User::factory()->create(['id' => 1]),
        );

        $activity = Activity::factory()->create(['id' => 1]);
        $this->deleteJson($this->url . '1');
        $this->assertModelMissing($activity);
    }
}
