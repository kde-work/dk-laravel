<?php

namespace App\DTO;

use App\Models\User;
use DateTime;
use OpenAPI\Server\Model\User as OpenApiUser;

class UserDTO
{
    public function __construct(
        public ?int     $id = 0,
        public ?string  $name = null,
        public ?int     $age = null,
        public ?float   $height = null,
        public ?bool    $children = null,
        public ?string  $photo = null,
        public ?array   $photos = null,
        public DateTime $birthdate = new DateTime,
        public ?string  $chatId = null,
        public ?bool    $hasChat = null
    )
    {
    }

    public static function fromUser(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            age: $user->age,
            height: $user->height,
            children: $user->children,
            photo: $user->photo,
            photos: $user->photos ?? [],
            birthdate: $user->birthdate,
            chatId: $user->chatId,
            hasChat: $user->hasChat
        );
    }

    public function toOpenApiModel(): OpenApiUser
    {
        return new OpenApiUser(
            name: $this->name,
            age: $this->age,
            height: $this->height,
            children: $this->children,
            photo: $this->photo,
            photos: $this->photos ?? [],
            birthdate: $this->birthdate,
            chatId: $this->chatId,
            hasChat: $this->hasChat,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            age: $data['age'] ?? null,
            height: $data['height'] ?? null,
            children: $data['children'] ?? null,
            photo: $data['photo'] ?? null,
            photos: $data['photos'] ?? null,
            birthdate: $data['birthdate'] ?? null,
            chatId: $data['chatId'] ?? null,
            hasChat: $data['hasChat'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'height' => $this->height,
            'children' => $this->children,
            'photo' => $this->photo,
            'photos' => $this->photos,
            'birthdate' => $this->birthdate,
            'chatId' => $this->chatId,
            'hasChat' => $this->hasChat
        ], fn($value) => $value !== null);
    }
}
