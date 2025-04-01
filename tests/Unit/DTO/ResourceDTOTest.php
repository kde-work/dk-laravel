<?php

namespace Tests\Unit\DTO;

use App\DTO\ResourceDTO;
use PHPUnit\Framework\TestCase;

class ResourceDTOTest extends TestCase
{
    /**
     * Тест метода fromArray.
     */
    public function testFromArrayCreatesCorrectObject(): void
    {
        $data = [
            'id' => 1,
            'name' => 'filter value 1',
            'selected' => true,
        ];

        $dto = ResourceDTO::fromArray($data);

        $this->assertSame(1, $dto->id);
        $this->assertSame('filter value 1', $dto->name);
        $this->assertTrue($dto->selected);
    }

    /**
     * Тест метода toArray.
     */
    public function testToArrayReturnsCorrectData(): void
    {
        $dto = new ResourceDTO(
            id: 2,
            name: 'filter value 2',
            selected: false
        );

        $array = $dto->toArray();

        $this->assertSame([
            'id' => 2,
            'name' => 'filter value 2',
            'selected' => false,
        ], $array);
    }
}
