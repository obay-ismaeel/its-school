<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => fake()->numberBetween(1, 6),
            'is_principle' => fake()->boolean(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'bio' => fake()->text(),
            'phone_number' => '09' . fake()->numberBetween(10000000, 99999999),
            'address' => fake()->address(),
            'username' => fake()->unique()->userName(),
            'password' => fake()->password(),
            'image_url' => 'default_image.png',
            'gender' => fake()->randomElement(['male', 'female']),
            'date_of_birth' => fake()->date()
        ];
    }
}
