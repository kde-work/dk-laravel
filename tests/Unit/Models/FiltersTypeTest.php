<?php

namespace Tests\Unit\Models;

use App\Models\Filter;
use App\Models\FiltersType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FiltersTypeTest extends TestCase
{
    use RefreshDatabase;

    public function testFillableAttributesAreCorrect(): void
    {
        $expected = ['name', 'validation'];

        $this->assertEquals($expected, (new FiltersType())->getFillable());
    }

    public function testHasManyFiltersRelationship(): void
    {
        $filtersType = FiltersType::factory()
            ->has(Filter::factory()->count(3))
            ->create();

        $this->assertCount(3, $filtersType->filters);
    }

    public function testFiltersTypeCanBeCreated(): void
    {
        $filtersType = FiltersType::factory()->create([
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ]);

        $this->assertDatabaseHas('filters_types', [
            'id' => $filtersType->id,
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ]);
    }
}
