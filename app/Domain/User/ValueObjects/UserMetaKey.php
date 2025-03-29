<?php

namespace App\Domain\User\ValueObjects;

enum UserMetaKey: string
{
    case AVATAR = 'avatar';
    case GALLERY = 'gallery';

    public static function fromString(string $key): self
    {
        return match ($key) {
            'avatar' => self::AVATAR,
            'gallery' => self::GALLERY,
            default => throw new \InvalidArgumentException("Invalid meta key: $key")
        };
    }
}
