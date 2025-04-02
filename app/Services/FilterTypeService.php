<?php

namespace App\Services;

use App\Models\FiltersType;
use App\DTO\FiltersTypeDTO;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FilterTypeService
{
    /**
     * Найти тип фильтра по ID.
     *
     * @param int $id
     * @return FiltersTypeDTO
     * @throws ModelNotFoundException
     */
    public function findById(int $id): FiltersTypeDTO
    {
        $filtersType = FiltersType::findOrFail($id);

        return FiltersTypeDTO::fromModel($filtersType);
    }

    /**
     * Найти тип фильтра по имени.
     *
     * @param string $name
     * @return FiltersTypeDTO
     * @throws ModelNotFoundException
     */
    public function findByName(string $name): FiltersTypeDTO
    {
        $filtersType = FiltersType::where('name', $name)->firstOrFail();

        return FiltersTypeDTO::fromModel($filtersType);
    }
}
