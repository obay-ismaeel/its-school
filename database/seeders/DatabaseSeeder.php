<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Guardian;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

            Admin::factory() -> create([
                'username' => 'majdham',
                'password' => bcrypt(123456),
                'first_name' => 'majd',
                'last_name' => 'hammad',
                'phone_number' => '0997311959',
                'address' => 'Damascus',
                'gender' => 'male',
            ]);

            Student::factory()->create([
                'username' => 'obayism',
                'password' => bcrypt(456789),
                'first_name' => 'obay',
                'middle_name' => 'hany',
                'last_name' => 'ismail',
                'date_of_birth' => fake()->date(),
                'address' => fake()->address(),
                'phone_number' => fake()->phoneNumber(),
                'bio' => fake()->text(),
                'gender' => fake()->randomElement(['male', 'female']),
                'type' => fake()->randomElement(['scientific','literary','basic']),
            ]);

            Teacher::factory()->create([
                'username' => 'obayism',
                'password' => bcrypt(456789),
                'first_name' => 'obay',
                'last_name' => 'ismail',
                'date_of_birth' => fake()->date(),
                'address' => fake()->address(),
                'phone_number' => fake()->phoneNumber(),
                'bio' => fake()->text(),
                'gender' => fake()->randomElement(['male', 'female']),
                'image_url' => fake()->url(),
            ]);

            Guardian::factory()->create([
                'username' => 'obayism',
                'password' => bcrypt(456789),
                'first_name' => 'obay',
                'last_name' => 'ismail',
                'phone_number' => fake()->phoneNumber(),
                'job' => fake()->text(),
                'gender' => fake()->randomElement(['male', 'female']),
                'email' => fake()->email(),
            ]);

    }
}
