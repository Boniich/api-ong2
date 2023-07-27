<?php

namespace Tests\Feature;

use App\Models\Contact;
use Database\Seeders\ContactSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{

    use RefreshDatabase;

    private string $url = 'api/v1/contacts/';

    public function test_contacts_retrived_successfully(): void
    {
        $this->seed(ContactSeeder::class);
        $response = $this->getJson($this->url);

        $response->assertJson(['success' => true, 'data' => [['id' => 1]], 'message' => 'Contacts retrived successfully'])->assertStatus(200);
    }

    public function test_retrived_one_contact_by_id_successfully(): void
    {
        $this->seed(ContactSeeder::class);
        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Contact retrived successfully'])->assertStatus(200);
    }

    public function test_not_found_contact_to_show(): void
    {
        $response = $this->getJson($this->url . '1');

        $response->assertJson(['success' => false, 'error' => 'Contact not found'])->assertStatus(404);
    }

    public function test_contact_created_successfully()
    {
        $response = $this->postJson($this->url, [
            'name' => 'Marcos',
            'email' => 'marcos@gmail.com',
            'phone' => '11111',
            'message' => 'mensaje de marcos',
        ]);

        $response->assertJson(['success' => true, 'data' => ['name' => 'Marcos', 'email' => 'marcos@gmail.com'], 'message' => 'Contact created successfully'])
            ->assertStatus(201);
    }

    public function test_bad_request_at_create_one_contact()
    {
        $response = $this->postJson($this->url, [
            'name' => 'Marcos',
            'message' => 'mensaje de marcos',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request']);
    }

    public function test_contact_updated_successfully()
    {
        $this->seed(ContactSeeder::class);
        $response = $this->putJson($this->url . '1', [
            'name' => 'Camila',
            'email' => 'Camila@gmail.com',
            'phone' => '2222',
            'message' => 'mensaje de camila',
        ]);

        $response->assertJson(['success' => true, 'data' => ['name' => 'Camila', 'email' => 'Camila@gmail.com'], 'message' => 'Contact updated successfully'])
            ->assertStatus(200);
    }

    public function test_contact_deleted_successfully()
    {
        $this->seed(ContactSeeder::class);
        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Contact deleted successfully']);
    }
}
