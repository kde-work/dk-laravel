<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoService
{
    /**
     * Загружает одну или несколько фотографий.
     *
     * @param UploadedFile|UploadedFile[] $files
     * @return string|array Путь или массив путей к сохраненным файлам
     */
    public function upload(array|UploadedFile $files): array|string
    {
        if (is_array($files)) {
            return $this->uploadMultiple($files);
        }
        return $this->uploadSingle($files);
    }

    /**
     * Загружает одну фотографию.
     *
     * @param UploadedFile $file
     * @return string Путь к сохраненному файлу
     */
    private function uploadSingle(UploadedFile $file): string
    {
        $path = Storage::disk('public')->putFileAs(
            'photos',
            $file,
            $this->generateFilename($file)
        );

        return Storage::url($path);
    }

    /**
     * Загружает несколько фотографий.
     *
     * @param UploadedFile[] $files
     * @return array Массив путей к сохраненным файлам
     */
    private function uploadMultiple(array $files): array
    {
        return array_map([$this, 'uploadSingle'], $files);
    }

    /**
     * Генерирует уникальное имя файла.
     *
     * @param UploadedFile $file
     * @return string
     */
    private function generateFilename(UploadedFile $file): string
    {
        return Str::uuid() . '.' . $file->getClientOriginalExtension();
    }
}
