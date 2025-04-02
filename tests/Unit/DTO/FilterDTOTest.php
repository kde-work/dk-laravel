<?php

namespace Tests\Unit\DTO;

use App\DTO\FilterDTO;
use App\DTO\FiltersTypeDTO;
use App\Models\Filter;
use App\Models\FiltersType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterDTOTest extends TestCase
{
    use RefreshDatabase;

    public function testFromModelCreatesDtoCorrectly(): void
    {
        $filtersType = FiltersType::factory()->create([
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ]);

        $filter = Filter::factory()->for($filtersType, 'type')->create([
            'value' => 'Test Value',
        ]);

        $dto = FilterDTO::fromModel($filter);

        // Проверяем, что DTO создан корректно
        $this->assertInstanceOf(FilterDTO::class, $dto);
        $this->assertEquals($filter->id, $dto->id);
        $this->assertEquals('Test Value', $dto->value);

        // Проверяем связь с FiltersTypeDTO
        $this->assertInstanceOf(FiltersTypeDTO::class, $dto->type);
        $this->assertEquals($filtersType->id, $dto->type->id);
        $this->assertEquals('Test Type', $dto->type->name);
        $this->assertEquals('required|string|max:255', $dto->type->validation);
    }

    public function testToArrayReturnsCorrectStructure(): void
    {
        $filtersType = FiltersType::factory()->create([
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ]);

        $filter = Filter::factory()->for($filtersType, 'type')->create([
            'value' => 'Test Value',
        ]);

        $dto = FilterDTO::fromModel($filter);

        $array = $dto->toArray();

        // Проверяем структуру массива
        $this->assertIsArray($array);
        $this->assertEquals([
            'id' => $filter->id,
            'value' => 'Test Value',
            'type' => [
                'id' => $filtersType->id,
                'name' => 'Test Type',
                'validation' => 'required|string|max:255',
            ],
        ], $array);
    }
}
