<?php

namespace Tests\Unit\Services;

use App\Services\ImageProcessorService;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImageProcessorServiceTest extends TestCase
{
    private ImageProcessorService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $imageManager = new ImageManager(
            new Driver()
        );

        $this->service = new ImageProcessorService($imageManager, 80);

        Storage::fake('public');
    }

    public function testProcessImageWithMultipleFormats()
    {
        $file = UploadedFile::fake()->image('test.jpg', 800, 600);
        $originalPath = $file->store('photos', 'public');

        $formats = ['png', 'webp', 'avif'];
        $result = $this->service->processImage(
            Storage::disk('public')->path($originalPath),
            $formats
        );

        foreach ($formats as $format) {
            $expectedPath = 'photos/' . pathinfo($originalPath, PATHINFO_FILENAME) . '.' . $format;

            // Проверяем существование файла
            Storage::disk('public')->assertExists($expectedPath);

            // Проверяем возвращаемые пути
            $this->assertEquals(
                Storage::url($expectedPath),
                $result[$format]
            );
        }
    }
}
