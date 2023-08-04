<?php

namespace Database\Factories;

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
            'section_id' => fake()->numberBetween(1, 6),
            //'grade_id' => fake()->numberBetween(1, 3),
            'username' => fake()->unique()->userName(),
            'password' => fake()->password(),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['male', 'female']),
            'address' => fake()->address(),
            'phone_number' => '09' . fake()->numberBetween(10000000, 99999999),
            'bio' => fake()->text(),
            'image_url' => 'default_image.png',
            'date_of_birth' => fake()->date(),
            'type' => fake()->randomElement(['literary', 'scientific', 'basic'])
        ];
    }
}
