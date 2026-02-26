<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
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
            'email' => fake()->unique()->safeEmail(),
            'image' => 'students/default.png',
            'country_id' => Country::inRandomOrder()->value('id'),
            'user_id' => User::factory(),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
