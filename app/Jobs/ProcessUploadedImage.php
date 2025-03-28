<?php

namespace App\Jobs;

use App\DTO\ImageProcessingDTO;
use App\Services\ImageProcessorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;
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
            $image = Image::make(
                Storage::path($this->dto->imageUpload->path)
            );

            $processor->processImage(
                $image,
                $this->dto->formats,
                $this->dto->quality
            );

            $this->updateImageUploadModel();
            $image->destroy();
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }

    private function updateImageUploadModel(): void
    {
        $this->dto->imageUpload->update([
            'processed' => true,
            'formats' => $this->dto->formats
        ]);
    }
}
