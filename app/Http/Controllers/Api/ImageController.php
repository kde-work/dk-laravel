<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DTO\ImageProcessingDTO;
use App\Jobs\ProcessUploadedImage;
use App\Models\ImageUpload;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240'
        ]);

        $path = $request->file('image')->store('uploads');
        $imageUpload = ImageUpload::create(['path' => $path]);

        $dto = new ImageProcessingDTO(
            imageUpload: $imageUpload,
            formats: config('image.formats', ['webp']),
            quality: config('image.quality', 80)
        );

        ProcessUploadedImage::dispatch($dto)
            ->onQueue('image-processing');

        return response()->json([
            'id' => $imageUpload->id,
            'status' => 'processing'
        ], 202);
    }
}
