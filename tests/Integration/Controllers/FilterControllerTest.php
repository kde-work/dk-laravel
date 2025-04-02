<?php

namespace Tests\Integration\Controllers;

use App\DTO\FilterDTO;
use App\Models\Filter;
use App\Models\FiltersType;
use App\Models\User;
use App\Services\FilterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;
use Tests\TestCase;

class FilterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected MockInterface $filterService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filterService = $this->mock(FilterService::class);
    }

    public function testIndexReturnsFilters(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $filtersType = FiltersType::factory()->create([
            'name' => 'Test Type',
            'validation' => 'required|string|max:255',
        ]);
        $filter = Filter::factory()->for($user)->for($filtersType, 'type')->create();

        $this->filterService->shouldReceive('getUserFilters')
            ->once()
            ->andReturn([
                new FilterDTO(
                    id: $filter->id,
                    value: 'Value',
                    type: FiltersType::factory()->create([
                        'validation' => 'required|string|max:255',
                    ])->toDTO()
                )
            ]);

        $response = $this->getJson('/api/v2/filters');

        $response->assertStatus(200)
            ->assertJson([
                'filters' => [
                    ['id' => $filter->id]
                ]
            ]);
    }
}
