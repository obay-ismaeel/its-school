<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

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
    }
}
