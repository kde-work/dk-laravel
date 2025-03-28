<?php

namespace App\Services;

use App\Domain\Image\ValueObjects\ImageFormat;
use Intervention\Image\Image;

class ImageProcessorService
{
    public function __construct(
        private int $defaultQuality = 80
    )
    {
    }

    public function processImage(
        Image $image,
        array $formats,
        ?int  $quality = null
    ): void
    {
        $quality = $quality ?? $this->defaultQuality;

        foreach ($formats as $format) {
            $imageFormat = new ImageFormat($format);
            $this->convertToFormat($image, $imageFormat, $quality);
        }
    }

    private function convertToFormat(
        Image       $image,
        ImageFormat $format,
        int         $quality
    ): void
    {
        $image->encode($format->value())->save(null, $quality);
    }
}
