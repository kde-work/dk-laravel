<?php

namespace Tests\Integration\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

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

        $response->assertStatus(200);

        $data = $response->json();

        $this->assertEquals('Updated Name', $data['name']);

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
            'currentPassword' => 'secret',
            'newPassword' => 'new_password123',
        ];

        $response = $this->patchJson('/api/v2/user/password', $data);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Пароль обновлен']);

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

    public function testUpdateProfilePhoto()
    {
        $oldPhoto = $this->user->photo;

        Sanctum::actingAs($this->user);

        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->patchJson('/api/v2/user/photo', ['photo' => $file]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Фото обновлено']);

        $this->assertNotNull($this->user->fresh()->toDTO()->photo);
        $this->assertNotEquals($oldPhoto, $this->user->fresh()->toDTO()->photo);
    }

    public function testUpdatePhotos()
    {
        $oldPhotos = $this->user->photos ?? [];

        Sanctum::actingAs($this->user);
        Storage::fake('public');

        $files = [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.jpg'),
            UploadedFile::fake()->image('photo3.jpg'),
        ];

        $response = $this->patchJson('/api/v2/user/photos', [
            'photos' => $files
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Коллекция фото обновлена'
            ]);

        $updatedUser = $this->user->fresh()->toDTO();

        $this->assertNotEquals($oldPhotos, $updatedUser->photos);

        $this->assertCount(3, $updatedUser->photos);

        foreach ($updatedUser->photos as $photoPath) {
            Storage::disk('public')->assertExists(str_replace('/storage/', '', $photoPath));
        }

        $response->assertJsonStructure([
            'message',
            'user' => [
                'photos'
            ]
        ]);
    }

    public function testFileStorageIntegration()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg');
        $filename = 'custom_name.jpg';

        Storage::disk('public')
            ->putFileAs('photos', $file, $filename);

        Storage::disk('public')->assertExists("photos/{$filename}");

        $this->assertFileDoesNotExist(
            storage_path("app/public/photos/{$filename}")
        );
    }

    public function testDeleteUser()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson('/api/v2/user');

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }
}
