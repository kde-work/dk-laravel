<?php

namespace App\DTO;

use App\Models\ImageUpload;

readonly class ImageProcessingDTO
{
    public function __construct(
        public ImageUpload $imageUpload,
        public array       $formats = ['webp', 'avif'],
        public int         $quality = 80
    ) {}
}
