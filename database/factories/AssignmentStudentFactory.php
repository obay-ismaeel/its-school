<?php

namespace Database\Factories;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssignmentStudent>
 */
class AssignmentStudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //'student_id' => 2,
            //'assignment_id' => Assignment::factory()->create()->id,
            'is_done' => fake()->boolean()
        ];
    }
}
