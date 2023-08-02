<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['sciences', 'physics', 'mathematics',
                                                        'history', 'geography', 'philosophy']),
            'description' => fake()->text(),
            'image_path' => fake()->url()
        ];
    }
}
