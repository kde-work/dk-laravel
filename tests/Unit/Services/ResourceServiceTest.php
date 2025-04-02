<?php

namespace Tests\Unit\Services;

use App\Services\ResourceService;
use App\DTO\ResourceDTO;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class ResourceServiceTest extends TestCase
{
    public function testGetResources(): void
    {
        $mockJson = json_encode([
            ['id' => 1, 'name' => 'filter value 1', 'selected' => false],
            ['id' => 2, 'name' => 'filter value 2', 'selected' => true],
        ]);

        $mockDisk = Mockery::mock(Filesystem::class);
        $mockDisk->shouldReceive('get')
            ->once()
            ->with('filters.json')
            ->andReturn($mockJson);

        Storage::shouldReceive('disk')
            ->once()
            ->with('public')
            ->andReturn($mockDisk);

        $service = new ResourceService();

        $result = $service->getResources('filters.json');

        $this->assertCount(2, $result);
        $this->assertInstanceOf(ResourceDTO::class, $result[0]);
        $this->assertEquals(1, $result[0]->id);
        $this->assertEquals('filter value 1', $result[0]->name);
        $this->assertFalse($result[0]->selected);
    }

    public function testResourcesFiltersRoute()
    {
        $response = $this->getJson('/api/v2/resources/filters');

        $response->assertStatus(200);

        $data = $response->json();

        $this->assertIsArray($data);
    }
}
