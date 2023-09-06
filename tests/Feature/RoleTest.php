<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RoleTest extends TestCase
{

    use RefreshDatabase;

    private string $url = 'api/v1/roles/';

    public function test_get_all_roles_successfully(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(['id' => 1]);
        $user->assignRole(1); //admin
        Sanctum::actingAs($user);

        $response = $this->getJson($this->url);

        $response->assertJson(['success' => true, 'data' => [['id' => '1']], 'message' => 'Roles retrived successfully'])->assertStatus(200);
    }

    public function test_get_one_role_successfully(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(['id' => 1]);
        $user->assignRole(1); //admin
        Sanctum::actingAs($user);

        $response = $this->getJson($this->url . '2');

        $response->assertJson(['success' => true, 'data' => ['id' => '2'], 'message' => 'Role retrived successfully'])->assertStatus(200);
    }

    public function test_not_found_response_at_try_to_show_a_role()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(['id' => 1]);
        $user->assignRole(1); //admin
        Sanctum::actingAs($user);

        $response = $this->getJson($this->url . '100');

        $response->assertJson(['success' => false, 'error' => 'Role not found'])->assertStatus(404);
    }


    public function test_update_one_role_in_data_base_successfully()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(['id' => 1]);
        $user->assignRole(1); //admin
        Sanctum::actingAs($user);

        $this->putJson($this->url . '1', [
            'name' => 'role updated'
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'role updated'
        ]);
    }


    public function test_successfully_response_at_try_to_update_one_role()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(['id' => 1]);
        $user->assignRole(1); //admin
        Sanctum::actingAs($user);

        $response = $this->putJson($this->url . '1', [
            'name' => 'role updated'
        ]);

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Role updated successfully'])->assertStatus(200);
    }

    public function test_bad_request_response_at_try_to_update_one_role()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(['id' => 1]);
        $user->assignRole(1); //admin
        Sanctum::actingAs($user);

        $response = $this->putJson($this->url . '1', [
            'name' => ''
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_not_found_role_response_at_try_to_update_one_role()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(['id' => 1]);
        $user->assignRole(1); //admin
        Sanctum::actingAs($user);

        $response = $this->putJson($this->url . '100', [
            'name' => 'role updated'
        ]);

        $response->assertJson(['success' => false, 'error' => 'Role not found'])->assertStatus(404);
    }
}
