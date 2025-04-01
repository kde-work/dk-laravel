<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private UserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new UserRepository(new User());
    }

    public function testAllReturnsUsers(): void
    {
        User::factory()->count(5)->create();

        $users = $this->repository->all();

        $this->assertCount(5, $users);
    }

    public function testFindReturnsCorrectUser(): void
    {
        $user = User::factory()->create(['name' => 'Test User']);

        $foundUser = $this->repository->find($user->id);

        $this->assertEquals('Test User', $foundUser->name);
    }

    public function testCreateAddsNewUser(): void
    {
        $data = ['name' => 'New User', 'email' => 'new@example.com', 'password' => bcrypt('password')];
        $user = $this->repository->create($data);

        $this->assertDatabaseHas('users', ['name' => 'New User']);
        $this->assertEquals('New User', $user->name);
    }

    public function testUpdateChangesUserData(): void
    {
        $user = User::factory()->create(['name' => 'Old Name']);

        $updated = $this->repository->update($user->id, ['name' => 'New Name']);

        $this->assertTrue($updated);
        $this->assertDatabaseHas('users', ['name' => 'New Name']);
    }

    public function testDeleteRemovesUser(): void
    {
        $user = User::factory()->create();

        $deleted = $this->repository->delete($user->id);

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
