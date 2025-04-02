<?php

namespace App\DTO;

readonly class FilterDTO
{
    public function __construct(
        public int            $id,
        public mixed          $value,
        public FiltersTypeDTO $type
    )
    {
    }

    public static function fromModel($filter): self
    {
        return new self(
            id: $filter->id,
            value: $filter->value,
            type: FiltersTypeDTO::fromModel($filter->type),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'type' => $this->type->toArray(),
        ];
    }
}
