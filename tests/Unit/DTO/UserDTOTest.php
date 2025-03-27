<?php

namespace Tests\Unit\DTO;

use App\DTO\UserDTO;
use App\Models\User;
use DateTime;
use OpenAPI\Server\Model\User as OpenApiUser;
use Tests\TestCase;

class UserDTOTest extends TestCase
{
    public function testFromUser(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'age' => 25,
            'height' => 165.0,
            'children' => false,
            'photo' => 'jane.jpg',
            'photos' => ['jane1.jpg', 'jane2.jpg'],
            'birthdate' => new DateTime('1995-05-05'),
            'chatId' => 'chat456',
            'hasChat' => false
        ]);

        $dto = UserDTO::fromUser($user);

        $this->assertEquals($user->id, $dto->id);
        $this->assertEquals('Jane Doe', $dto->name);
        $this->assertEquals(25, $dto->age);
        $this->assertEquals(165.0, $dto->height);
        $this->assertFalse($dto->children);
        $this->assertEquals('jane.jpg', $dto->photo);
        $this->assertEquals(['jane1.jpg', 'jane2.jpg'], $dto->photos);
        $this->assertEquals(new DateTime('1995-05-05'), $dto->birthdate);
        $this->assertEquals('chat456', $dto->chatId);
        $this->assertFalse($dto->hasChat);
    }

    public function testFromArray(): void
    {
        $data = [
            'id' => 2,
            'name' => 'Bob Smith',
            'age' => 40,
            'height' => 175.5,
            'children' => true,
            'photo' => 'bob.jpg',
            'photos' => ['bob1.jpg', 'bob2.jpg'],
            'birthdate' => new DateTime('1980-12-31'),
            'chatId' => 'chat789',
            'hasChat' => true
        ];

        $dto = UserDTO::fromArray($data);

        $this->assertEquals(2, $dto->id);
        $this->assertEquals('Bob Smith', $dto->name);
        $this->assertEquals(40, $dto->age);
        $this->assertEquals(175.5, $dto->height);
        $this->assertTrue($dto->children);
        $this->assertEquals('bob.jpg', $dto->photo);
        $this->assertEquals(['bob1.jpg', 'bob2.jpg'], $dto->photos);
        $this->assertEquals(new DateTime('1980-12-31'), $dto->birthdate);
        $this->assertEquals('chat789', $dto->chatId);
        $this->assertTrue($dto->hasChat);
    }

    public function testToArray(): void
    {
        $dto = new UserDTO(
            id: 3,
            name: 'Alice Johnson',
            age: 35,
            height: 170.0,
            children: false,
            photo: 'alice.jpg',
            photos: ['alice1.jpg', 'alice2.jpg'],
            birthdate: new DateTime('1985-06-15'),
            chatId: 'chat101',
            hasChat: true
        );

        $array = $dto->toArray();

        $this->assertEquals([
            'id' => 3,
            'name' => 'Alice Johnson',
            'age' => 35,
            'height' => 170.0,
            'children' => false,
            'photo' => 'alice.jpg',
            'photos' => ['alice1.jpg', 'alice2.jpg'],
            'birthdate' => new DateTime('1985-06-15'),
            'chatId' => 'chat101',
            'hasChat' => true
        ], $array);
    }

    public function testToOpenApiModel(): void
    {
        $dto = new UserDTO(
            id: 4,
            name: 'Eve Wilson',
            age: 28,
            height: 168.5,
            children: true,
            photo: 'eve.jpg',
            photos: ['eve1.jpg', 'eve2.jpg'],
            birthdate: new DateTime('1993-03-20'),
            chatId: 'chat202',
            hasChat: false
        );

        $openApiUser = $dto->toOpenApiModel();

        $this->assertInstanceOf(OpenApiUser::class, $openApiUser);
        $this->assertEquals('Eve Wilson', $openApiUser->getName());
        $this->assertEquals(28, $openApiUser->getAge());
        $this->assertEquals(168.5, $openApiUser->getHeight());
        $this->assertTrue($openApiUser->getChildren());
        $this->assertEquals('eve.jpg', $openApiUser->getPhoto());
        $this->assertEquals(['eve1.jpg', 'eve2.jpg'], $openApiUser->getPhotos());
        $this->assertEquals(new DateTime('1993-03-20'), $openApiUser->getBirthdate());
        $this->assertEquals('chat202', $openApiUser->getChatId());
        $this->assertFalse($openApiUser->getHasChat());
    }
}
