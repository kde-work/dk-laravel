<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenAPI\Server\Model\User as OpenApiUser;
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
            'children' => 2,
            'photo' => 'avatar.jpg',
            'photos' => ['img1.jpg', 'img2.jpg'],
            'birthdate' => '2000-01-01',
            'chatId' => '12345',
            'hasChat' => true,
        ]);
    }

    public function testFillableAttributesAreCorrect()
    {
        $user = new User();

        $fillable = [
            'name', 'email', 'password', 'age', 'height', 'children',
            'photo', 'photos', 'birthdate', 'chatId', 'hasChat',
        ];

        $this->assertEquals($fillable, $user->getFillable());
    }

    public function testHiddenAttributesAreCorrect()
    {
        $user = new User();
        $hidden = ['password', 'remember_token'];

        $this->assertEquals($hidden, $user->getHidden());
    }

    public function testCastsAreCorrect()
    {
        $user = new User();
        $expectedCasts = [
            'id' => 'int',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthdate' => 'date',
            'photos' => 'array',
            'hasChat' => 'boolean',
        ];


        $this->assertEquals($expectedCasts, $user->getCasts());
    }

    public function testPasswordIsHashed()
    {
        $user = User::factory()->make(['password' => 'secret']);

        $this->assertNotEquals('secret', $user->password);
        $this->assertTrue(password_verify('secret', $user->password));
    }
}
