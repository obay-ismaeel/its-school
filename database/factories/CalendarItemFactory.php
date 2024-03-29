<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalendarItem>
 */
class CalendarItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->dateTime(),
            'title' => fake()->sentence(),
            'content' => fake()->text(),
            'type' => fake()->randomElement(['meeting','holiday','event'])
        ];
    }
}
