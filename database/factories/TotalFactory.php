<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Total>
 */
class TotalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => fake()->numberBetween(1, 90),
            'grade_course_id' =>fake()->numberBetween(1, 18),
            'year' => fake()->year(),
            'first_term_score' => fake()->numberBetween(120, 200),
            'second_term_score' => fake()->numberBetween(120, 200),
            'final_score' => fake()->numberBetween(120, 200),
            'has_failed' => fake()->boolean()
        ];
    }
}
