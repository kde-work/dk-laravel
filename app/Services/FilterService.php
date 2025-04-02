<?php

namespace App\Services;

use App\Models\Filter;
use App\DTO\FilterDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FilterService
{
    public function getUserFilters(): array
    {
        return Filter::where('user_id', Auth::user()->id)
            ->with('type')
            ->get()
            ->map(fn($filter) => FilterDTO::fromModel($filter))
            ->toArray();
    }

    /**
     * @param FilterDTO[] $filtersDTO
     * @throws ValidationException
     */
    public function updateUserFilters(array $filtersDTO): void
    {
        foreach ($filtersDTO as $filterDTO) {
            $filter = Filter::findOrFail($filterDTO->id);
            $type = $filter->type;

            Validator::make(
                ['value' => $filterDTO->value],
                ['value' => $type->validation]
            )->validate();

            $filter->update([
                'value' => $filterDTO->value,
            ]);
        }
    }
}
