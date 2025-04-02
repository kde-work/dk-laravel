<?php

namespace Tests\Unit\Services;

use App\DTO\FiltersTypeDTO;
use App\Models\FiltersType;
use App\Services\FilterTypeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterTypeServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testFindByIdReturnsDto(): void
    {
        $filtersType = FiltersType::factory()->create([
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ]);

        $service = new FilterTypeService();

        $result = $service->findById($filtersType->id);

        $this->assertInstanceOf(FiltersTypeDTO::class, $result);
        $this->assertEquals($filtersType->id, $result->id);
        $this->assertEquals('Test Type', $result->name);
        $this->assertEquals('required|string|max:255', $result->validation);
    }

    public function testFindByIdThrowsModelNotFoundException(): void
    {
        $service = new FilterTypeService();

        $this->expectException(ModelNotFoundException::class);

        $service->findById(999);
    }

    public function testFindByNameReturnsDto(): void
    {
        $filtersType = FiltersType::factory()->create([
            'name' => 'Test Type 2',
            'validation' => 'required|string|max:255',
        ]);

        $service = new FilterTypeService();

        $result = $service->findByName('Test Type 2');

        $this->assertInstanceOf(FiltersTypeDTO::class, $result);
        $this->assertEquals($filtersType->id, $result->id);
        $this->assertEquals('Test Type 2', $result->name);
        $this->assertEquals('required|string|max:255', $result->validation);
    }

    public function testFindByNameThrowsModelNotFoundException(): void
    {
        $service = new FilterTypeService();

        $this->expectException(ModelNotFoundException::class);

        $service->findByName('Nonexistent Type');
    }
}
