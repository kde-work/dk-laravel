<?php

namespace Tests\Unit\Models;

use App\Models\Filter;
use App\Models\User;
use App\Models\FiltersType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    public function testFillableAttributesAreCorrect(): void
    {
        $expected = ['user_id', 'value', 'filters_type_id'];

        $this->assertEquals($expected, (new Filter())->getFillable());
    }

    public function testBelongsToUserRelationship(): void
    {
        $user = User::factory()->create();
        $filter = Filter::factory()->for($user)->create();

        $this->assertTrue($filter->user->is($user));
    }

    public function testBelongsToFiltersTypeRelationship(): void
    {
        $filtersType = FiltersType::factory()->create();
        $filter = Filter::factory()->for($filtersType, 'type')->create();

        $this->assertTrue($filter->type->is($filtersType));
    }

    public function testFilterCanBeCreated(): void
    {
        $user = User::factory()->create();
        $filtersType = FiltersType::factory()->create();

        $filter = Filter::factory()->create([
            'user_id' => $user->id,
            'filters_type_id' => $filtersType->id,
            'value' => 'Test Value',
        ]);

        $this->assertDatabaseHas('filters', [
            'id' => $filter->id,
            'user_id' => $user->id,
            'filters_type_id' => $filtersType->id,
            'value' => 'Test Value',
        ]);
    }
}
