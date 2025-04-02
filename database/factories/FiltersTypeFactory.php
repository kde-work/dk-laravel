<?php

namespace Database\Factories;

use App\Models\FiltersType;
use Illuminate\Database\Eloquent\Factories\Factory;

class FiltersTypeFactory extends Factory
{
    protected $model = FiltersType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['checkbox', 'select', 'int']),
            'validation' => $this->faker->randomElement([
                'required|boolean',
                'required|in:electronics,books,clothing',
                'required|integer|min:18'
            ]),
        ];
    }
}
