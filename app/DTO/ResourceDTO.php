<?php

namespace App\DTO;

readonly class ResourceDTO
{
    public function __construct(
        public int    $id,
        public string $name,
        public bool   $selected
    )
    {
    }

    /**
     * Создание DTO из массива.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            selected: $data['selected']
        );
    }

    /**
     * Преобразование DTO в массив.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'selected' => $this->selected,
        ];
    }
}
