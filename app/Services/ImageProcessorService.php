<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use App\Domain\Image\ValueObjects\ImageFormat;

class ImageProcessorService
{
    public function __construct(
        private ImageManager $imageManager,
        private int          $defaultQuality = 80
    )
    {
    }

    public function processImage(
        string $imagePath,
        array  $formats,
        ?int   $quality = null
    ): array
    {
        $quality = $quality ?? $this->defaultQuality;
        $results = [];

        try {
            $image = $this->imageManager->read($imagePath);

            foreach ($formats as $format) {
                $imageFormat = new ImageFormat($format);
                $newPath = $this->convertToFormat($image, $imageFormat, $quality);
                $results[$format] = $newPath;
            }

            return $results;
        } finally {
            if (isset($image)) {
                $image->core()->native()->destroy();
            }
        }
    }

    private function convertToFormat(
        ImageInterface $image,
        ImageFormat    $format,
        int            $quality
    ): string
    {
        $newPath = $this->generateNewPath($image->origin()->filepath(), $format->value());

        $image->encodeByExtension($format->value(), [
            'quality' => $quality
        ])->save($newPath);

        return $newPath;
    }

    private function generateNewPath(string $originalPath, string $format): string
    {
        $info = pathinfo($originalPath);
        return $info['dirname'] . '/' . $info['filename'] . '.' . $format;
    }
}
