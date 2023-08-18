<?php

namespace Database\Factories;

use App\Models\GradeCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grade_course_id' => GradeCourse::inRandomOrder()->first()->id,
            'teacher_id' => fake()->numberBetween(1, 6),
            'section_id' => fake()->numberBetween(1, 6),
            'title' => fake()->word(),
            'content' => fake()->text(),
            'due_date' => fake()->date(),
            'type' => fake()->randomElement(['assignment', 'homework'])
        ];
    }
}
