<?php

namespace App\Services;

use App\DTO\ResourceDTO;
use Illuminate\Support\Facades\Storage;

class ResourceService
{
    public function getResources(string $fileName, string $storage = 'public'): array
    {
        $data = json_decode(Storage::disk($storage)->get($fileName), true);

        return array_map(fn($item) => ResourceDTO::fromArray($item), $data);
    }
}
