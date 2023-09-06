<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    private string $urlRegister = 'api/v1/register';
    private string $urlLogin = 'api/v1/login';

    public function test_register_successfully(): void
    {
        $this->seed(RoleSeeder::class);

        $response = $this->postJson($this->urlRegister, [
            'name' => 'Testint test',
            'email' => 'test45@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        $response->assertJson(['success' => true, 'data' => [
            'name' => 'Testint test',
            'email' => 'test45@gmail.com',
        ]])->assertStatus(200);
    }

    public function test_bad_request_at_register()
    {
        $response = $this->postJson($this->urlRegister, [
            'name' => 'Testint test',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }

    public function test_login_successfully()
    {
        User::factory(1)->create(['id' => 1, 'email' => 'auth@gmail.com', 'password' => '123456']);

        $response = $this->postJson($this->urlLogin, [
            'email' => 'auth@gmail.com',
            'password' => '123456',
        ]);

        $response->assertJson(['success' => true, 'data' => ['id' => 1, 'email' => 'auth@gmail.com'], 'message' => 'Login successfully'])->assertStatus(200);
    }

    public function test_validation_error_at_login()
    {
        User::factory(1)->create(['id' => 1, 'email' => 'auth@gmail.com', 'password' => '123456']);
        $response = $this->postJson($this->urlLogin, [
            'email' => 'auth@gmail.com',
            'password' => '123',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Invalid Credentials'])->assertStatus(401);
    }

    public function test_bad_request_at_login()
    {
        User::factory(1)->create(['id' => 1, 'email' => 'auth@gmail.com', 'password' => '123456']);
        $response = $this->postJson($this->urlLogin, [
            'password' => '123456',
        ]);

        $response->assertJson(['success' => false, 'error' => 'Bad Request'])->assertStatus(400);
    }
}
