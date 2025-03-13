<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест успешной регистрации пользователя.
     *
     * @return void
     */
    public function testUserCanRegister(): void
    {
        $response = $this->postJson('/api/v2/auth/register', [
            'email' => 'test2@example.com',
            'password' => 'password123_!',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'access_token',
                     'token_type',
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test2@example.com',
        ]);
    }

    /**
     * Тест невозможности регистрации с некорректными данными.
     *
     * @return void
     */
    public function testUserCannotRegisterWithInvalidData(): void
    {
        $response = $this->postJson('/api/v2/auth/register', [
            'email' => 'invalid-email',
            'password' => 'short',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * Тест успешного входа пользователя.
     *
     * @return void
     */
    public function testUserCanLogin(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/v2/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'access_token',
                     'token_type',
                 ]);
    }

    /**
     * Тест невозможности входа с неверными учетными данными.
     *
     * @return void
     */
    public function testUserCannotLoginWithInvalidCredentials(): void
    {
        $response = $this->postJson('/api/v2/auth/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Неверные учетные данные',
                 ]);
    }
}
