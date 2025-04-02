<?php

namespace Tests\Unit\Services;

use App\DTO\FilterDTO;
use App\Models\Filter;
use App\Models\FiltersType;
use App\Models\User;
use App\Services\FilterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class FilterServiceTest extends TestCase
{
    use RefreshDatabase;

    private FilterService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new FilterService();
    }

    public function testGetUserFilters(): void
    {
        $user = User::factory()->create();
        Auth::loginUsingId($user->id);
        $filtersType = FiltersType::factory()->create([
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ]);
        $filter = Filter::factory()->for($user)->for($filtersType, 'type')->create([
            'value' => 'Test Value',
        ]);

        $result = $this->service->getUserFilters();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(FilterDTO::class, $result[0]);
        $this->assertEquals($filter->id, $result[0]->id);
        $this->assertEquals('Test Value', $result[0]->value);
        $this->assertEquals($filtersType->id, $result[0]->type->id);
    }

    public function testUpdateUserFilters(): void
    {
        $user = User::factory()->create();
        Auth::loginUsingId($user->id);
        $filtersType = FiltersType::factory()->create([
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ]);
        $filter = Filter::factory()->for($user)->for($filtersType, 'type')->create([
            'value' => 'Old Value',
        ]);

        $filterDTO = new FilterDTO(
            id: $filter->id,
            value: 'Updated Value',
            type: FiltersType::factory()->create([
                'validation' => 'required|string|max:255',
            ])->toDTO()
        );

        $this->service->updateUserFilters([$filterDTO]);

        $this->assertDatabaseHas('filters', [
            'id' => $filter->id,
            'value' => 'Updated Value',
        ]);
    }

    public function testUpdateUserFiltersThrowsValidationException(): void
    {
        Auth::loginUsingId(1);
        $user = User::factory()->create();
        Auth::loginUsingId($user->id);
        $filtersType = FiltersType::factory()->create([
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ]);
        $filter = Filter::factory()->for($user)->for($filtersType, 'type')->create([
            'value' => null,
        ]);

        $filterDTO = new FilterDTO(
            id: $filter->id,
            value: null,
            type: FiltersType::factory()->create([
                'validation' => 'required|string|max:255',
            ])->toDTO()
        );

        $this->expectException(ValidationException::class);

        $this->service->updateUserFilters([$filterDTO]);
    }
}
