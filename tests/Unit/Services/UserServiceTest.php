<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UserService;
use App\DTO\UserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }

    public function testUpdateProfile()
    {
        $user = User::factory()->create();
        $userDTO = new UserDTO(
            name: 'Updated Name',
            age: 30,
        );

        $updatedUser = $this->userService->updateProfile($user, $userDTO);

        $this->assertEquals('Updated Name', $updatedUser->name);
        $this->assertEquals(30, $updatedUser->age);
    }

    public function testUpdateEmail()
    {
        $user = User::factory()->create(['email' => 'old@example.com']);
        $newEmail = 'new@example.com';

        $updatedUser = $this->userService->updateEmail($user, $newEmail);

        $this->assertEquals($newEmail, $updatedUser->email);
    }

    public function testUpdatePasswordSuccess()
    {
        $currentPassword = 'current_password';
        $newPassword = 'new_password';

        $user = User::factory()->create([
            'password' => Hash::make($currentPassword),
        ]);

        $this->userService->updatePassword($user, $currentPassword, $newPassword);

        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    public function testUpdatePasswordThrowsExceptionOnInvalidCurrentPassword()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Неверный текущий пароль');

        $currentPassword = 'wrong_password';
        $newPassword = 'new_password';

        $user = User::factory()->create([
            'password' => Hash::make('current_password'),
        ]);

        $this->userService->updatePassword($user, $currentPassword, $newPassword);
    }

    public function testUpdateProfilePhoto()
    {
        $photoPath = '/images/profile.jpg';
        $user = User::factory()->create();

        $updatedUser = $this->userService->updateProfilePhoto($user, $photoPath);

        $this->assertEquals($photoPath, $updatedUser->photo);
    }

    public function testUpdatePhotos()
    {
        $photos = ['/images/photo1.jpg', '/images/photo2.jpg'];
        $user = User::factory()->create();

        $updatedUser = $this->userService->updatePhotos($user, $photos);

        $this->assertEquals($photos, $updatedUser->photos);
    }

    public function testDeleteUser()
    {
        $user = User::factory()->create();

        // Ensure the user exists before deletion
        $this->assertDatabaseHas('users', ['id' => $user->id]);

        // Perform deletion
        $this->userService->deleteUser($user);

        // Ensure the user no longer exists in the database
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
