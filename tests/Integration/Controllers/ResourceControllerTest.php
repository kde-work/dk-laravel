<?php

namespace Tests\Integration\Controllers;

use App\Http\Controllers\Api\ResourceController;
use App\Services\ResourceService;
use App\DTO\ResourceDTO;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class ResourceControllerTest extends TestCase
{
    protected ResourceService $resourceService;
    protected ResourceController $resourceController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resourceService = $this->createMock(ResourceService::class);
        $this->resourceController = new ResourceController($this->resourceService);
    }

    public function testGetFiltersReturnsJsonResponse(): void
    {
        $mockData = [
            ['id' => 1, 'name' => 'filter value 1', 'selected' => false],
            ['id' => 2, 'name' => 'filter value 2', 'selected' => true],
        ];

        $this->resourceService->method('getResources')
            ->willReturn(array_map(fn($item) => ResourceDTO::fromArray($item), $mockData));

        $response = $this->resourceController->getFilters();

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertArrayHasKey('filters', $response->getData(true));
        $this->assertCount(2, $response->getData(true)['filters']);

        $expectedData = array_map(fn($item) => ResourceDTO::fromArray($item)->toArray(), $mockData);
        $actualData = array_map(fn($dto) => $dto, $response->getData(true)['filters']);

        $this->assertEquals($expectedData, $actualData);
    }
}
