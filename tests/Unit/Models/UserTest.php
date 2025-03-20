<?php

namespace Tests\Unit\Models;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

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

    public function testFillableAttributesAreCorrect(): void
    {
        $expected = [
            'name', 'email', 'password', 'age', 'height', 'children',
            'photo', 'photos', 'birthdate', 'chatId', 'hasChat',
        ];

        $this->assertEquals($expected, (new User())->getFillable());
    }

    public function testHiddenAttributesAreCorrect(): void
    {
        $this->assertEquals(
            ['password', 'remember_token'],
            (new User())->getHidden()
        );
    }

    public function testCastsAreCorrect(): void
    {
        $expected = [
            'id' => 'int',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthdate' => 'date',
            'photos' => 'array',
            'hasChat' => 'boolean',
        ];

        $this->assertEquals($expected, (new User())->getCasts());
    }

    public function testPasswordIsHashed(): void
    {
        $user = User::factory()->make(['password' => 'secret']);

        $this->assertNotEquals('secret', $user->password);
        $this->assertTrue(password_verify('secret', $user->password));
    }

    public function testConvertsToDtoCorrectly(): void
    {
        $dto = $this->user->toDTO();

        $this->assertInstanceOf(UserDTO::class, $dto);
        $this->assertEquals('Test User', $dto->name);
        $this->assertEquals(25, $dto->age);
        $this->assertEquals(180.5, $dto->height);
        $this->assertTrue($dto->children);
        $this->assertEquals('avatar.jpg', $dto->photo);
        $this->assertEquals(['img1.jpg', 'img2.jpg'], $dto->photos);
        $this->assertEquals('2000-01-01', $dto->birthdate->format('Y-m-d'));
        $this->assertEquals('12345', $dto->chatId);
        $this->assertTrue($dto->hasChat);
    }

    public function _testHandlesNullPhotosInDto(): void
    {
        $user = User::factory()->create(['photos' => null]);
        $dto = $user->toDTO();

        $this->assertIsArray($dto->photos);
        $this->assertEmpty($dto->photos);
    }

    public function testChildrenFieldIsBoolean(): void
    {
        $user = User::factory()->create(['children' => false, 'birthdate' => '2000-01-01',]);

        $this->assertFalse((bool) $user->children);

        $user->update(['children' => true]);
        $this->assertTrue((bool) $user->refresh()->children);

        $dto = $user->toDTO();
        $this->assertTrue($dto->children);
    }
}
