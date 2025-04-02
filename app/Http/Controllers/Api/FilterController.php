<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FilterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\DTO\FilterDTO;
use Illuminate\Validation\ValidationException;

class FilterController extends Controller
{
    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(): JsonResponse
    {
        return response()->json(['filters' => $this->filterService->getUserFilters()], 200);
    }

    public function update(Request $request): JsonResponse
    {
        // Валидация структуры запроса.
        $data = $request->validate([
            'filters' => 'required|array',
            'filters.*.id' => 'required|integer',
            'filters.*.name' => 'required|string',
            'filters.*.value' => 'required',
        ]);

        $filtersDTO = array_map(
            fn($filterData) => FilterDTO::fromArray($filterData),
            $data['filters']
        );

        try {
            $this->filterService->updateUserFilters($filtersDTO);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Не удалось провалидировать данные фильтров. ' . $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Filters updated successfully'], 200);
    }
}
