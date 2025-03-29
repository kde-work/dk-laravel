<?php

namespace App\Domain\Image\ValueObjects;

class ImageMetadata
{
    public function __construct(
        public readonly string $path,
        public readonly array  $formats,
        public readonly bool   $processed = false
    )
    {
    }
}
