<?php

namespace Tests\Unit\DTO;

use App\DTO\FiltersTypeDTO;
use App\Models\FiltersType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FiltersTypeDTOTest extends TestCase
{
    use RefreshDatabase;

    public function testFromModelCreatesDtoCorrectly(): void
    {
        $filtersType = FiltersType::factory()->create([
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ]);

        $dto = FiltersTypeDTO::fromModel($filtersType);

        $this->assertInstanceOf(FiltersTypeDTO::class, $dto);
        $this->assertEquals($filtersType->id, $dto->id);
        $this->assertEquals('Test Type', $dto->name);
        $this->assertEquals('required|string|max:255', $dto->validation);
    }

    public function testToArrayReturnsCorrectStructure(): void
    {
        $filtersType = FiltersType::factory()->create([
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ]);

        $dto = FiltersTypeDTO::fromModel($filtersType);

        $array = $dto->toArray();

        $this->assertIsArray($array);
        $this->assertEquals([
            'id' => $filtersType->id,
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ], $array);
    }
}
