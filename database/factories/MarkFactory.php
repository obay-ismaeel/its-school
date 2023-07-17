<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mark>
 */
class MarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => fake()->numberBetween(1, 91),
            'grade_course_id' => fake()->numberBetween(1, 18),
            'type' => fake()->randomElement(['practical','exam','test']),
            'score' => fake()->numberBetween(100, 200),
            'term' => fake()->randomElement(['first', 'second']),
            'year' => now()->year
        ];
    }
}
