<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ResourceService;
use Illuminate\Http\JsonResponse;

class ResourceController extends Controller
{
    protected ResourceService $resourceService;

    public function __construct(ResourceService $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function getFilters(): JsonResponse
    {
        $resources = $this->resourceService->getResources('filters.json');

        return response()->json(['filters' => array_map(fn($dto) => $dto->toArray(), $resources)], 200);
    }
}
