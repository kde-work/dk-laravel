<?php

namespace App\Domain\Image\ValueObjects;

use InvalidArgumentException;

class ImageFormat
{
    private const SUPPORTED = ['webp', 'avif', 'jpg', 'png'];

    public function __construct(private string $value)
    {
        if (!in_array($value, self::SUPPORTED)) {
            throw new InvalidArgumentException("Unsupported format: {$value}");
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
