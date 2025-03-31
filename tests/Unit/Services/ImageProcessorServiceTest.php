<?php

namespace Tests\Unit\Services;

use App\Services\ImageProcessorService;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Exceptions\DecoderException;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageProcessorServiceTest extends TestCase
{
    private ImageProcessorService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $imageManager = new ImageManager(new Driver());
        $this->service = new ImageProcessorService($imageManager, 80);
    }

    public function testProcessImageSuccessfully(): void
    {
        // Подготовка тестового изображения
        Storage::fake('public');
        $originalPath = 'test-images/original.jpg';
        Storage::disk('public')->put($originalPath, file_get_contents(__DIR__ . '/fixtures/original.jpg'));

        // Выполняем обработку изображения
        $results = $this->service->processImage(
            Storage::disk('public')->path($originalPath),
            ['webp', 'jpg']
        );

        // Проверяем, что пути приведены к единому виду и файлы созданы
        foreach (['webp', 'jpg'] as $format) {
            $expectedPath = str_replace('.jpg', ".$format", Storage::disk('public')->path($originalPath));
            $this->assertArrayHasKey($format, $results);
            $this->assertEquals($expectedPath, $results[$format]);
            Storage::disk('public')->assertExists(str_replace('.jpg', ".$format", $originalPath));
        }
    }

    public function testProcessImageThrowsDecoderExceptionForInvalidInput(): void
    {
        $this->expectException(DecoderException::class);

        // Передаем некорректный путь
        $this->service->processImage('/invalid/path/to/image.jpg', ['webp']);
    }

}
