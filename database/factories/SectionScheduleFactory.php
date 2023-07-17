<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SectionSchedule>
 */
class SectionScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grade_course_id' => fake()->numberBetween(1, 18),
            'section_id' => fake()->numberBetween(1, 6),
            'start_at' => fake()->time(),
            'end_at' => fake()->time(),
            'day' => fake()->randomElement(['sunday','monday','tuesday','wednesday','thursday']),
            'order' => fake()->numberBetween(1, 7)
        ];
    }
}
