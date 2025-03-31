<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Usermeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Usermeta>
 */
class UsermetaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        {
            return [
                'user_id' => User::factory(),
                'key' => $this->faker->word,
                'value' => $this->faker->word,
            ];
        }
    }
}
