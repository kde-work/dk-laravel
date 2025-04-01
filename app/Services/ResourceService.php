<?php

namespace App\Services;

use App\DTO\ResourceDTO;
use Illuminate\Support\Facades\Storage;

class ResourceService
{
    /**
     * Получение ресурсов из JSON-файла и преобразование в массив DTO.
     */
    public function getResources(string $filePath): array
    {
        $data = json_decode(Storage::get($filePath), true);

        return array_map(fn($item) => ResourceDTO::fromArray($item), $data);
    }
}
