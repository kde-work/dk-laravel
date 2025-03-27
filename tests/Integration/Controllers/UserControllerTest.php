<?php

namespace Tests\Integration\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret',
            'age' => 25,
            'height' => 180.5,
            'children' => true,
            'photo' => 'avatar.jpg',
            'photos' => ['img1.jpg', 'img2.jpg'],
            'birthdate' => '2000-01-01',
            'chatId' => '12345',
            'hasChat' => true,
        ]);
    }

    public function testShowUserProfile()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/v2/user');

        $response->assertStatus(200);

        $data = $response->json();

        $this->assertEquals($this->user->name, $data['name']);
        $this->assertEquals($this->user->email, $data['email']);
    }

    public function testUpdateUserProfile()
    {
        Sanctum::actingAs($this->user);

        $data = [
            'name' => 'Updated Name',
            'age' => 30,
            'height' => 180.5,
            'children' => true,
        ];

        $response = $this->putJson('/api/v2/user', $data);

        $response->assertStatus(200)
            ->assertJson(['name' => 'Updated Name']);

        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
    }

    public function testUpdateEmail()
    {
        Sanctum::actingAs($this->user);

        $data = ['email' => 'new@example.com'];

        $response = $this->patchJson('/api/v2/user/email', $data);

        $response->assertStatus(200)
            ->assertJson(['email' => 'new@example.com']);

        $this->assertDatabaseHas('users', ['email' => 'new@example.com']);
    }

    public function testUpdatePasswordSuccess()
    {
        Sanctum::actingAs($this->user);

        $data = [
            'currentPassword' => 'current_password',
            'newPassword' => 'new_password123',
        ];

        $response = $this->patchJson('/api/v2/user/password', $data);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Пароль обновлен']);

        // Проверяем, что пароль обновился
        $this->assertTrue(Hash::check('new_password123', $this->user->fresh()->password));
    }

    public function testUpdatePasswordInvalidCurrentPassword()
    {
        Sanctum::actingAs($this->user);

        $data = [
            'currentPassword' => 'wrong_password',
            'newPassword' => 'new_password123',
        ];

        $response = $this->patchJson('/api/v2/user/password', $data);

        $response->assertStatus(400)
            ->assertJson(['error' => 'Неверный текущий пароль']);
    }

    public function tesstUpdateProfilePhoto()
    {
        Sanctum::actingAs($this->user);

        \Storage::fake('public');

        $file = \Illuminate\Http\UploadedFile::fake()->image('photo.jpg');

        $response = $this->patchJson('/api/v2/user/photo', ['photo' => $file]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Фото обновлено']);

        \Storage::disk('public')->assertExists($file->hashName());
    }

    public function testDeleteUser()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson('/api/v2/user');

        $response->assertStatus(204);

        // Убедимся, что пользователь удален из базы данных
        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }
}
