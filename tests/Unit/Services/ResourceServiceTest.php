<?php

namespace Tests\Unit\Services;

use App\Services\ResourceService;
use App\DTO\ResourceDTO;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ResourceServiceTest extends TestCase
{
    /**
     * Тест метода getResources.
     */
    public function testGetResources(): void
    {
        $mockJson = json_encode([
            ['id' => 1, 'name' => 'filter value 1', 'selected' => false],
            ['id' => 2, 'name' => 'filter value 2', 'selected' => true],
        ]);

        Storage::shouldReceive('get')
            ->once()
            ->with('private/filters.json')
            ->andReturn($mockJson);

        $service = new ResourceService();

        $result = $service->getResources('private/filters.json');

        $this->assertCount(2, $result);
        $this->assertInstanceOf(ResourceDTO::class, $result[0]);
        $this->assertEquals(1, $result[0]->id);
        $this->assertEquals('filter value 1', $result[0]->name);
        $this->assertFalse($result[0]->selected);
    }
}
