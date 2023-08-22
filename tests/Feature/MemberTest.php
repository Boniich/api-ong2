<?php

namespace Tests\Feature;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MemberTest extends TestCase
{

    use RefreshDatabase;

    private string $url = 'api/v1/members/';

    public function test_get_all_member_successfully(): void
    {
        Member::factory(1)->create(['id' => 1]);

        $response = $this->getJson($this->url);

        $response->assertJson(['success' => true, 'data' => [['id' => 1]], 'message' => 'Members retrived successfully'])->assertStatus(200);
    }

    public function test_get_one_member_by_id_successfully(): void
    {
        Member::factory(1)->create(['id' => 1, 'full_name' => 'Fernando dias']);
        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1, 'full_name' => 'Fernando dias'], 'message' => 'Member retrived successfully'])->assertStatus(200);
    }

    public function test_not_found_member(): void
    {
        Member::factory(1)->create(['id' => 1, 'full_name' => 'Fernando dias']);
        $response = $this->getJson($this->url . '5');
        $response->assertJson(['success' => false, 'error' => 'Member not found'])->assertStatus(404);
    }

    public function test_create_member_successfully(): void
    {
        $response = $this->postJson($this->url, [
            'id' => 1,
            'full_name' => 'Carlos Pepe',
            'description' => 'Soy un miembro de la ONG',
        ]);

        $response->assertJson(['success' => true, 'data' => ['full_name' => 'Carlos Pepe', 'description' => 'Soy un miembro de la ONG'], 'message' => 'Member created successfully'])
            ->assertStatus(201);
    }

    public function test_update_member_successfully(): void
    {
        Member::factory(1)->create(['id' => 1, 'full_name' => 'Fernando Dias']);
        $response = $this->putJson($this->url . '1', [
            'full_name' => 'Maria Dias',
        ]);

        $response->assertJson(['success' => true, 'data' => ['full_name' => 'Maria Dias'], 'message' => 'Member updated successfully'])
            ->assertStatus(200);
    }

    public function test_not_found_member_to_update(): void
    {
        $response = $this->putJson($this->url . '3', [
            'full_name' => 'Maria Dias',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Member not found'])->assertStatus(404);
    }

    public function test_destroy_member_successfully(): void
    {
        Member::factory(1)->create(['id' => 1, 'full_name' => 'Fernando Dias']);
        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['full_name' => 'Fernando Dias'], 'message' => 'Member deleted successfully'])
            ->assertStatus(200);
    }

    public function test_not_found_member_to_destroy()
    {
        $response = $this->deleteJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Member not found'])->assertStatus(404);
    }
}
