<?php

namespace App\DTO;

class UserDTO
{
    public function __construct(
        public ?string $name = null,
        public ?int    $age = null,
        public ?float  $height = null,
        public ?bool   $children = null,
        public ?string $photo = null,
        public ?array  $photos = null,
        public ?string $birthdate = null,
        public ?string $chatId = null,
        public ?bool   $hasChat = null
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
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
