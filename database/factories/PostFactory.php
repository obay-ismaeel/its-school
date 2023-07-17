<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => fake()->numberBetween(1, 6),
            'grade_id' => fake()->numberBetween(1, 3),
            'title' => fake()->word(),
            'content' => fake()->text(),
            'type' => fake()->randomElement(['educational', 'news'])
        ];
    }
}
