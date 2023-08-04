<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guardian>
 */
class GuardianFactory extends Factory
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
            'password' => fake()->password(),
            'email' => fake()->email(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => '09' . fake()->numberBetween(10000000, 99999999),
            'job' => fake()->jobTitle(),
            'gender' => fake()->randomElement(['male','female'])
        ];
    }
}
