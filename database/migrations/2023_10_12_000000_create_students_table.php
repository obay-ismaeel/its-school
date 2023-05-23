<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('grade_id')->nullable();
            //$table->foreignId('section_id')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            //$table->string('address');
            //$table->string('phone_number');
            // $table->string('first_name');
            // $table->string('middle_name');
            // $table->string('last_name');
            // $table->date('date_of_birth');
            // $table->text('bio')->default('Your hobbies and the things you like the most!');
            // $table->enum('type',['scientific','literary','basic']);
            // $table->enum('gender',['male','female']);
            // $table->string('image_url')->nullable();
            // $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
