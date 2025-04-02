<?php

namespace App\DTO;

readonly class FiltersTypeDTO
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $validation
    )
    {
    }

    public static function fromModel($type): self
    {
        return new self(
            id: $type->id,
            name: $type->name,
            validation: $type->validation,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'validation' => $this->validation,
        ];
    }
}
