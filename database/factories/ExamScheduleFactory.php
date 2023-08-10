<?php

namespace Database\Factories;

use App\Models\GradeCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamSchedule>
 */
class ExamScheduleFactory extends Factory
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
            'start_at' => fake()->dateTime(),
            'duartion' => fake()->datetime(),
            'type' => fake()->randomElement(['exam','test','quiz'])
        ];
    }
}
