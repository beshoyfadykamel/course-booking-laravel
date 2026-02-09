<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'image' => 'students/default.png', // Assuming a default image exists or just a placeholder
            'country_id' => Country::inRandomOrder()->first()->id ?? 1, // Get random country or default to 1
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
