<?php

namespace Database\Factories;

use App\Models\Filter;
use App\Models\User;
use App\Models\FiltersType;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilterFactory extends Factory
{
    protected $model = Filter::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'value' => $this->faker->randomElement([
                $this->faker->boolean(),
                $this->faker->randomElement(['electronics', 'books', 'clothing']),
                $this->faker->numberBetween(18, 100)
            ]),
            'filters_type_id' => FiltersType::factory(),
        ];
    }
}
