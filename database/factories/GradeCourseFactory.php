<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GradeCourse>
 */
class GradeCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grade_id' => fake()->numberBetween(1,10),
            'course_id' => fake()->numberBetween(1,20),
            'description' => fake()->sentence()
        ];
    }
}
