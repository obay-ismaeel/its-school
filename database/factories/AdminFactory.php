<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'password' => bcrypt('password'),
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'phone_number' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'gender' => fake()->randomElement(['male','female'])
        ];
    }
}
