<?php

namespace App\Jobs;

use App\DTO\ImageProcessingDTO;
use App\Services\ImageProcessorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class ProcessUploadedImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private ImageProcessingDTO $dto
    )
    {
    }

    public function handle(ImageProcessorService $processor): void
    {
        try {
            $imageManager = new ImageManager(new Driver());
            $imagePath = Storage::path($this->dto->imageUpload->path);

            $processedPaths = $processor->processImage(
                $imagePath,
                $this->dto->formats,
                $this->dto->quality
            );

            $this->updateImageUploadModel($processedPaths);
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }

    private function updateImageUploadModel(array $processedPaths): void
    {
        $this->dto->imageUpload->update([
            'processed' => true,
            'formats' => array_keys($processedPaths),
            'processed_paths' => $processedPaths
        ]);
    }
}
