<?php

namespace App\DTO;

use App\Models\ImageUpload;

class ImageProcessingDTO
{
    public function __construct(
        public readonly ImageUpload $imageUpload,
        public readonly array $formats = ['webp', 'avif'],
        public readonly int $quality = 80
    ) {}
}
