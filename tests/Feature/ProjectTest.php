<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    private string $url = 'api/v1/projects/';

    public function test_retrived_data_projects_successfully(): void
    {
        Project::factory(1)->create(['id' => 1]);

        $response = $this->getJson($this->url);

        destroyImagesInTestsForArrayWithIndex($response);

        $response->assertJson(['success' => true, 'data' => [['id' => 1]], 'message' => 'Projects retrived successfully'])->assertStatus(200);
    }

    public function test_retrived_one_project_by_id_successfully(): void
    {
        Project::factory(1)->create(['id' => 1]);
        $response = $this->getJson($this->url . '1');

        destroyImagesInTests($response);
        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Project retrived successfully'])->assertStatus(200);
    }

    public function test_project_to_show_not_found_successfully(): void
    {
        $response = $this->getJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Project not found'])->assertStatus(404);
    }

    public function test_create_a_new_project_successfully(): void
    {
        $response = $this->postJson($this->url, [
            'id' => 1,
            'title' => 'project test',
            'description' => 'este project es en los test',
            'image' => UploadedFile::fake()->image('imageTest.png'),
            'due_date' => '11/08/2023'
        ]);

        $response->assertJson(['success' => true, 'data' => [
            'id' => 1,
            'title' => 'project test',
            'description' => 'este project es en los test',
            'due_date' => '11/08/2023'
        ], 'message' => 'Project created successfully'])->assertStatus(201);

        //cambiar forma de eliminar
        destroyImagesInTests($response);
        // $data = Project::find(1);
        // destroyImage($data->image);
    }

    public function test_update_project_successfully(): void
    {
        Project::factory(1)->create(['id' => 1]);

        $response = $this->putJson($this->url . '1', [
            'title' => 'actualizando title',
            'description' => 'actualizando description',
            'image' => UploadedFile::fake()->image('imageTest.png'),
            'due_date' => '14/09/2024'
        ]);

        $response->assertJson(['success' => true, 'data' => [
            'title' => 'actualizando title',
            'description' => 'actualizando description',
            'due_date' => '14/09/2024'
        ], 'message' => 'Project updated successfully'])->assertStatus(200);

        //cambiar forma de eliminar
        destroyImagesInTests($response);
        // $data = Project::find(1);
        // destroyImage($data->image);
    }

    public function test_project_to_update_not_found_successfully(): void
    {
        $response = $this->putJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Project not found'])->assertStatus(404);
    }

    public function test_destroy_project_successfully(): void
    {
        Project::factory(1)->create(['id' => 1]);

        $response = $this->deleteJson($this->url . '1');

        $response->assertJson(['success' => true, 'data' => ['id' => 1], 'message' => 'Project deleted successfully'])->assertStatus(200);
    }

    public function test_project_to_delete_not_found_successfully(): void
    {
        $response = $this->deleteJson($this->url . '1');
        $response->assertJson(['success' => false, 'error' => 'Project not found'])->assertStatus(404);
    }
}
