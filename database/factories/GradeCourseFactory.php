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
            'course_id' => fake()->numberBetween(1, 6),
            'grade_id' => fake()->numberBetween(1, 3),
            'description' => fake()->text(),
            'number of weekly classes' => fake()->numberBetween(1, 5),
            'top_mark' => fake()->randomElement([200, 400, 600]),
            'lower_mark' => fake()->randomElement([80, 120])
        ];
    }
}
